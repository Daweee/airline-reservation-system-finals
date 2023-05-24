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
    public $bookingId;
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
            $sql = "SELECT fs.flight_id, fs.origin, fs.destination, fs.departure_date, fs.return_date, fs.flight_type,
            rf.origin AS return_destination, rf.destination AS return_origin, rf.departure_date AS return_departure_date
            FROM flight_schedule fs
            LEFT JOIN returning_flight rf ON fs.flight_id = rf.round_trip_flight_id
            WHERE fs.origin = :origin
            AND fs.destination = :destination
            AND fs.departure_date = :departDate
            AND (fs.return_date = :returnDate OR fs.return_date IS NULL)
            AND fs.flight_type = :flightType";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':origin', $this->userOrigin, PDO::PARAM_STR);
            $stmt->bindValue(':destination', $this->userDestination, PDO::PARAM_STR);
            $stmt->bindValue(':departDate', $this->userDepartDate, PDO::PARAM_STR);
            $stmt->bindValue(':returnDate', $this->userReturnDate, PDO::PARAM_STR);
            $stmt->bindValue(':flightType', $this->userFlightType, PDO::PARAM_STR);

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Flights');

            if ($stmt->execute()) {
                $flights = $stmt->fetchAll(PDO::FETCH_CLASS, 'Flights');

                foreach ($flights as $flight) {
                    $flight->returning_flight = $this->getReturningFlights($conn, $flight->flight_id);
                }

                return $flights;
            }
        }
    }

    private function getReturningFlights($conn, $roundTripFlightId)
    {
        $sql = "SELECT * 
        FROM returning_flight 
        WHERE round_trip_flight_id = :roundTripFlightId
        AND origin = :returnDestination
        AND destination = :returnOrigin
        AND departure_date = :returnDepartureDate";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':roundTripFlightId', $roundTripFlightId, PDO::PARAM_INT);
        $stmt->bindValue(':returnOrigin', $this->userOrigin, PDO::PARAM_STR);
        $stmt->bindValue(':returnDestination', $this->userDestination, PDO::PARAM_STR);
        $stmt->bindValue(':returnDepartureDate', $this->userReturnDate, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Flights');

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'Flights');
        }
    }



    public static function chosenFlightDetails($conn, $chosenFlightId)
    {
        $sql = "SELECT * 
                FROM flight_schedule 
                WHERE flight_id = :flight_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':flight_id', $chosenFlightId, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Flights');

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_CLASS);
        }
    }

    public function calculateTotalAmount($conn, $chosenFlightId, $adults, $children, $infants)
    {

        $sql = "INSERT INTO booking (adults, children, infants, total_price, flight_id)
                SELECT :adults, :children, :infants,
                    (:adults * 2000) + (:children * 700) + (:infants * 400), :flight_id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':adults', $adults, PDO::PARAM_INT);
        $stmt->bindValue(':children', $children, PDO::PARAM_INT);
        $stmt->bindValue(':infants', $infants, PDO::PARAM_INT);
        $stmt->bindValue(':flight_id', $chosenFlightId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $this->bookingId = $conn->lastInsertId();
            $totalPrice = ($adults * 2000) + ($children * 700) + ($infants * 400);
            return $totalPrice;
        } else {
            return false;
        }
    }
}
