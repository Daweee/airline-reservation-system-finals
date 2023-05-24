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

    <table class="summary-table">
        <tr>
            <td>
                <h2>Booking ID:</h2>
            </td>
            <td>
                <h2><?php echo $assignedBookingId; ?></h2>
            </td>
        </tr>
    </table>

    <h3>Flight Details</h3>
    <table class="summary-table">
        <tr>
            <td>Flight ID:</td>
            <td><?php echo $chosenFlight->flight_id; ?></td>
        </tr>
        <tr>
            <td>Origin:</td>
            <td><?php echo $chosenFlight->origin; ?></td>
        </tr>
        <tr>
            <td>Destination:</td>
            <td><?php echo $chosenFlight->destination; ?></td>
        </tr>
        <tr>
            <td>Departure Date:</td>
            <td><?php echo $chosenFlight->departure_date; ?></td>
        </tr>
        <tr>
            <td>Return Date:</td>
            <td><?php echo ($chosenFlight->return_date !== null ? $chosenFlight->return_date : "N/A"); ?></td>
        </tr>
        <tr>
            <td>Flight Type:</td>
            <td><?php echo $chosenFlight->flight_type; ?></td>
        </tr>
    </table>

    <h3>Guest Details</h3>
    <table class="summary-table">
        <tr>
            <td>Title:</td>
            <td><?php echo $guestTitle; ?></td>
        </tr>
        <tr>
            <td>First Name:</td>
            <td><?php echo $guestFirstName; ?></td>
        </tr>
        <tr>
            <td>Last Name:</td>
            <td><?php echo $guestLastName; ?></td>
        </tr>
        <tr>
            <td>Street Address:</td>
            <td><?php echo $streetAddress; ?></td>
        </tr>
        <tr>
            <td>Birthdate:</td>
            <td><?php echo $guestBirthDate; ?></td>
        </tr>
    </table>

    <h3>Total Amount</h3>
    <p class="total-amount">Total: ₱<span><?php echo $totalAmount; ?></span></p>
</body>
<a href="../index.php"><button>Go back Home</button></a>

</html>