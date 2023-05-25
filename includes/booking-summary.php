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

    $guestData = array();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Retrieve the selected flight ID from the session
            $selectedFlightID = $_SESSION['selectedFlightID'];
            $adults = $_SESSION['adults'];
            $children = $_SESSION['children'];
            $infants = $_SESSION['infants'];
            $selectedReturnFlightID = $_SESSION['returning_flight_ids'];

            $guests = $_POST['guests'];

            $chosenFlight = Flights::chosenFlightDetails($conn, $selectedFlightID);

            $totalAmount = $flight->calculateTotalAmount($conn, $selectedFlightID, $adults, $children, $infants);

            $assignedBookingId = $flight->bookingId;

            $adultGuests = array_slice($guests, 0, $adults);

            $childGuests = array_slice($guests, $adults + 1);

            $infantGuests = array_slice($guests, $adults + $children + 1);
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

        <h3>Flight Return Details</h3>
        <table class="summary-table">
            <tr>
                <td>Flight ID:</td>
                <td><?php echo $selectedReturnFlightID; ?></td>
            </tr>
            <tr>
                <td>Origin:</td>
                <td><?php echo $chosenFlight->destination; ?></td>
            </tr>
            <tr>
                <td>Destination:</td>
                <td><?php echo $chosenFlight->origin; ?></td>
            </tr>
            <tr>
                <td>Departure Date:</td>
                <td><?php echo ($chosenFlight->return_date !== null ? $chosenFlight->return_date : "N/A"); ?></td>
            </tr>
        </table>
    
        <h3>Guest Details</h3>
        <table class="summary-table">
        <?php
    
        foreach ($adultGuests as $guestIndex => $guestData) {
            $guestNumber = $guestIndex + 1;
            $guestTitle = $guestData['title'];
            $guestFirstName = $guestData['firstName'];
            $guestLastName = $guestData['lastName'];
            $guestBirthDate = $guestData['birthDate'];

            echo "<tr>";
            echo "<td>Adult Guest $guestNumber</td>";
            echo "<td></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Title:</td>";
            echo "<td>$guestTitle</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>First Name:</td>";
            echo "<td>$guestFirstName</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Last Name:</td>";
            echo "<td>$guestLastName</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Birth Date:</td>";
            echo "<td>$guestBirthDate</td>";
            echo "</tr>";
          
            echo "<tr><td></td><td></td></tr>"; 
        }

      
        foreach ($childGuests as $guestIndex => $guestData) {
            $guestNumber = $guestIndex + 1;
            $guestTitle = $guestData['title'];
            $guestFirstName = $guestData['firstName'];
            $guestLastName = $guestData['lastName'];
            $guestBirthDate = $guestData['birthDate'];

            echo "<tr>";
            echo "<td>Child Guest $guestNumber</td>";
            echo "<td></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Title:</td>";
            echo "<td>$guestTitle</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>First Name:</td>";
            echo "<td>$guestFirstName</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Last Name:</td>";
            echo "<td>$guestLastName</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Birth Date:</td>";
            echo "<td>$guestBirthDate</td>";
            echo "</tr>";

            echo "<tr><td></td><td></td></tr>"; 
        }

        foreach ($infantGuests as $guestIndex => $guestData) {
            $guestNumber = $guestIndex + 1;
            $guestTitle = $guestData['title'];
            $guestFirstName = $guestData['firstName'];
            $guestLastName = $guestData['lastName'];
            $guestBirthDate = $guestData['birthDate'];
           

            echo "<tr>";
            echo "<td>Infant Guest $guestNumber</td>";
            echo "<td></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Title:</td>";
            echo "<td>$guestTitle</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>First Name:</td>";
            echo "<td>$guestFirstName</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Last Name:</td>";
            echo "<td>$guestLastName</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Birth Date:</td>";
            echo "<td>$guestBirthDate</td>";
            echo "</tr>";
            
            echo "<tr><td></td><td></td></tr>";
    }
    }
    ?>
</table>

    <h3>Total Amount</h3>
    <p class="total-amount">Total: ₱<span><?php echo $totalAmount; ?></span></p>

</body>

</html>