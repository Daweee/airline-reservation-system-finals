<?php
require '../classes/Flights.php';
require '../classes/Database.php';

$db = new Database();
$conn = $db->getConn();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Booking Summary</title>
    <link rel="stylesheet" type="text/css" href="../css/bookingsummary.css">
</head>

<body>
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

        $assignedBookingId = $flight->bookingId;
    }
    ?>

    <h1>Booking Summary</h1>
    <h2>Booking ID: <?php echo $assignedBookingId; ?></h2>

    <h3>Flight Details</h3>
    <p>Flight ID: <?php echo $chosenFlight->flight_id; ?></p>
    <p>Origin: <?php echo $chosenFlight->origin; ?></p>
    <p>Destination: <?php echo $chosenFlight->destination; ?></p>
    <p>Departure Date: <?php echo $chosenFlight->departure_date; ?></p>
    <p>Return Date: <?php echo ($chosenFlight->return_date !== null ? $chosenFlight->return_date : "N/A"); ?></p>
    <p>Flight Type: <?php echo $chosenFlight->flight_type; ?></p>

    <h3>Guest Details</h3>
    <p>Title: <?php echo $guestTitle; ?></p>
    <p>First Name: <?php echo $guestFirstName; ?></p>
    <p>Last Name: <?php echo $guestLastName; ?></p>
    <p>Street Address: <?php echo $streetAddress; ?></p>
    <p>Birthdate: <?php echo $guestBirthDate; ?></p>

    <h3>Total Amount</h3>
    <p>Total: ₱<?php echo $totalAmount; ?></p>
</body>

</html>