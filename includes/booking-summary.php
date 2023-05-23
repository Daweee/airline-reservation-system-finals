<?php 
require '../classes/Flights.php';
require '../classes/Database.php';

$db = new Database();
$conn = $db->getConn();

?>

<?php

    session_start();

    $flight = new Flights();

    if (isset($_POST['guestTitle'], $_POST['guestFirstName'], $_POST['guestLastName'], $_POST['streetAddress'], $_POST['guestBirthDate'], $_SESSION['selectedFlightID'], $_SESSION['adults'], $_SESSION['children'], $_SESSION['infants'])) {
        // Retrieve the form data
        $guestTitle = $_POST['guestTitle'];
        $guestFirstName = $_POST['guestFirstName'];
        $guestLastName = $_POST['guestLastName'];
        $streetAddress = $_POST['streetAddress'];
        $guestBirthDate = $_POST['guestBirthDate'];
    
        // Retrieve the selected flight ID from the session
        $selectedFlightID = $_SESSION['selectedFlightID'];
        $adults = $_SESSION['adults'];
        $children = $_SESSION['children'];
        $infants = $_SESSION['infants'];
    
        $chosenFlight = Flights::chosenFlightDetails($conn, $selectedFlightID);

        $totalAmount = $flight->calculateTotalAmount($conn, $selectedFlightID, $adults, $children, $infants);

        echo "<h2>Booking Summary</h2>";
        echo "<h3>Flight Details</h3>";
        echo "Flight ID: " . $chosenFlight->flight_id . "<br>";
        echo "Origin: " . $chosenFlight->origin . "<br>";
        echo "Destination: " . $chosenFlight->destination . "<br>";
        echo "Departure Date: " . $chosenFlight->departure_date . "<br>";
        echo "Return Date: " . ($chosenFlight->return_date !== null ? $chosenFlight->return_date : "N/A") . "<br>";
        echo "Flight Type: " . $chosenFlight->flight_type . "<br>";

        echo "<h3>Guest Details</h3>";
        echo "Title: " . $guestTitle . "<br>";
        echo "First Name: " . $guestFirstName . "<br>";
        echo "Last Name: " . $guestLastName . "<br>";
        echo "Street Address: " . $streetAddress  . "<br>";
        echo "Birthdate: " . $guestBirthDate . "<br>";

        echo "<h3>Total Amount</h3>";
        echo "Total: ₱" . $totalAmount . "<br>";

        unset($_SESSION['selectedFlightID']);
    }       

?>