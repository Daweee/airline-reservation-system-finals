<!DOCTYPE html>
<html>

<head>
    <title>Admin Page</title>
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
</head>

<body>
    <h1>Admin Page</h1>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process the form data and add the flight to the database
        require 'includes/init.php';
        $conn = require 'includes/db.php';

        // Retrieve the form inputs for departing flight
        $flight_id = $_POST['flight_id'];
        $origin = $_POST['origin'];
        $destination = $_POST['destination'];
        $departure_date = $_POST['departure_date'];
        $return_date = $_POST['return_date'];
        $flight_type = $_POST['flight_type'];

        // Retrieve the form inputs for returning flight
        $return_flight_id = $_POST['return_flight_id'];
        $round_trip_flight_id = $_POST['round_trip_flight_id'];
        $return_origin = $_POST['return_origin'];
        $return_destination = $_POST['return_destination'];
        $return_departure_date = $_POST['return_departure_date'];
        $return_flight_type = $_POST['return_flight_type'];

        // Add code here to validate and sanitize the form inputs

        // Prepare and execute the SQL queries for departing flight
        $departingFlightQuery = "INSERT INTO flight_schedule (flight_id, origin, destination, departure_date, return_date, flight_type)
        VALUES (?, ?, ?, ?, ?, ?)";
        $departingFlightStmt = $conn->prepare($departingFlightQuery);

        if (empty($return_date)) {
            // If return date is not provided, bind NULL value
            $departingFlightStmt->bindValue(5, NULL);
        } else {
            // If return date is provided, bind the value
            $departingFlightStmt->bindParam(5, $return_date);
        }

        // Bind other parameters
        $departingFlightStmt->bindParam(1, $flight_id);
        $departingFlightStmt->bindParam(2, $origin);
        $departingFlightStmt->bindParam(3, $destination);
        $departingFlightStmt->bindParam(4, $departure_date);
        $departingFlightStmt->bindParam(6, $flight_type);

        $departingFlightResult = $departingFlightStmt->execute();

        // Prepare and execute the SQL queries for returning flight
        $returningFlightQuery = "INSERT INTO returning_flight (flight_id, round_trip_flight_id, origin, destination, departure_date, flight_type)
                            VALUES ('$return_flight_id', '$round_trip_flight_id', '$return_origin', '$return_destination', '$return_departure_date', '$return_flight_type')";
        $returningFlightResult = $conn->query($returningFlightQuery);

        // Check if the queries were successful
        if ($departingFlightResult && $returningFlightResult) {
            // Display a success message
            echo "<p>Flight added successfully!</p>";
        } else {
            // Display an error message
            echo "<p>Error adding flight: " . $conn->error . "</p>";
        }

        // Close the database connection
        // $conn->close();
    }
    ?>

    <h2>Flights</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="flight_id">Flight ID:</label>
        <input type="text" name="flight_id" id="flight_id" required><br>

        <label for="origin">Origin:</label>
        <input type="text" name="origin" id="origin" required><br>

        <label for="destination">Destination:</label>
        <input type="text" name="destination" id="destination" required><br>

        <label for="departure_date">Departure Date:</label>
        <input type="date" name="departure_date" id="departure_date" required><br>

        <label for="return_date">Return Date:</label>
        <input type="date" name="return_date" id="return_date"><br>

        <label for="flight_type">Flight Type:</label>
        <input type="text" name="flight_type" id="flight_type" required><br>


        <h2>Returning Flight</h2>

        <label for="return_flight_id">Return Flight ID:</label>
        <input type="text" name="return_flight_id" id="return_flight_id"><br>

        <label for="round_trip_flight_id">Round Trip Flight ID:</label>
        <input type="text" name="round_trip_flight_id" id="round_trip_flight_id"><br>

        <label for="return_origin">Origin:</label>
        <input type="text" name="return_origin" id="return_origin"><br>

        <label for="return_destination">Destination:</label>
        <input type="text" name="return_destination" id="return_destination"><br>

        <label for="return_departure_date">Departure Date:</label>
        <input type="date" name="return_departure_date" id="return_departure_date"><br>

        <label for="return_flight_type">Flight Type:</label>
        <input type="text" name="return_flight_type" id="return_flight_type"><br>


        <input type="submit" value="Add Flight">
    </form>
    <a href="index.php"><button>Go back Home</button></a>

</body>

</html>