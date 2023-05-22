<?php

class Flights
{
    public $userFlightType;
    public $userAdults;
    public $userChildren;
    public $userInfants;
    public $userOrigin;
    public $userDestination;
    public $userDepartDate;
    public $userReturnDate;
    public $flight_id;
    public $flight_type;
    public $adults;
    public $children;
    public $infants;
    public $origin;
    public $destination;
    public $departure_date;
    public $return_date;
    public $errors = [];

    protected function validate()
    {

        //validates if the provided origin and destination places are the same
        if ($this->userOrigin == $this->userDestination) {
            $this->errors[] = 'Select a different destination';
        }

        //validates if the provided departure date is valid or not
        if (empty($this->userDepartDate) || $this->userDepartDate == '0000-00-00') {
            $this->errors[] = 'Please select a valid departure date';
        } elseif (strtotime($this->userDepartDate) < strtotime(date('Y-m-d'))) {
            $this->errors[] = 'Departure date cannot be in the past';
        }

        //validates if the provided return date is valid or not
        if (!empty($this->userReturnDate) && $this->userReturnDate == '0000-00-00') {
            $this->errors[] = 'Please select a valid return date';
        } elseif (!empty($this->userReturnDate) && strtotime($this->userReturnDate) < strtotime(date('Y-m-d'))) {
            $this->errors[] = 'Return date cannot be in the past';
        } elseif (!empty($this->userReturnDate) && $this->userDepartDate >= $this->userReturnDate) {
            $this->errors[] = 'Return date cannot be the same as the departure date';
        }

        //validates if the return date is provided if the chosen flight type is round trip
        if ($this->userFlightType == 'roundtrip') {
            if (empty($this->userReturnDate) || $this->userReturnDate == '0000-00-00') {
                $this->errors[] = 'Please select a valid return date';
            } elseif (strtotime($this->userReturnDate) < strtotime(date('Y-m-d'))) {
                $this->errors[] = 'Return date cannot be in the past';
            } elseif ($this->userDepartDate == $this->userReturnDate) {
                $this->errors[] = 'Return date cannot be the same or less than the departure date';
            }
        }

        if ($this->userAdults == 0) {
            $this->errors[] = 'Number of adults must be greater than zero';
        }

        if ($this->userAdults == 0 && $this->userChildren > 0 && $this->userInfants > 0) {
            $this->errors[] = 'For the protection and welfare of everyone, we kindly request that minors are accompanied by an adult at all times.';
        }

        return empty($this->errors);
    }

    public function search($conn)
    {

        if ($this->validate()) {

            $sql = "SELECT * 
                    FROM flight_schedule 
                    WHERE origin = :origin
                    AND destination = :destination
                    AND departure_date = :departDate
                    AND (return_date = :returnDate OR return_date IS NULL)
                    AND flight_type = :flightType";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':origin', $this->userOrigin, PDO::PARAM_STR);
            $stmt->bindValue(':destination', $this->userDestination, PDO::PARAM_STR);
            $stmt->bindValue(':departDate', $this->userDepartDate, PDO::PARAM_STR);
            $stmt->bindValue(':returnDate', $this->userReturnDate, PDO::PARAM_STR);
            $stmt->bindValue(':flightType', $this->userFlightType, PDO::PARAM_STR);

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Flights');

            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'Flights');
            }
        }
    }

    public function addPeople($conn)
    {
        if ($this->validate()) {

            $sql = "INSERT INTO booking (adults, children, infants) 
                    VALUES (:adults, :children, :infants)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':adults', $this->userAdults, PDO::PARAM_INT);
            $stmt->bindValue(':children', $this->userChildren, PDO::PARAM_INT);
            $stmt->bindValue(':infants', $this->userInfants, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $this->bookingId = $conn->lastInsertId();
                return true;
            } else {
                return false;
            }
        }
    }
}
