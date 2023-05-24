<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyrine Airline Reservation System</title>
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <header>
        <h1>Results:</h1>
    </header>
    <div></div>
    <main class="main">
        <form action="/airline-reservation-system-finals/includes/guest-details.php" method="post" onsubmit="return validateForm();">
            <table>
                <thead>
                    <tr>
                        <th>Flight ID</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Departure Date</th>
                        <th>Return Date</th>
                        <th>Flight Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($searchResults !== null && count($searchResults) > 0) : ?>
                        <?php foreach ($searchResults as $result) : ?>
                            <?php $returningFlights = $result->returning_flight; ?>
                            <tr>
                                <td><?= $result->flight_id ?></td>
                                <td><?= $result->origin ?></td>
                                <td><?= $result->destination ?></td>
                                <td><?= $result->departure_date ?></td>
                                <td><?= ($result->return_date !== null) ? $result->return_date : "NULL" ?></td>
                                <td><?= $result->flight_type ?></td>
                                <td>
                                    <input type="radio" name="selectedFlight" value="<?= $result->flight_id ?>">
                                </td>
                            </tr>
                            <?php if (!empty($returningFlights)) : ?>
                                <?php foreach ($returningFlights as $returningFlight) : ?>
                                    <tr>
                                        <td><?= $returningFlight->flight_id ?></td>
                                        <td><?= $returningFlight->origin ?></td>
                                        <td><?= $returningFlight->destination ?></td>
                                        <td><?= $returningFlight->departure_date ?></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>

            </table>
            <label for="agreementCheckbox">
                <input type="checkbox" id="agreementCheckbox"> I accept the agreement
            </label>
            <br>
            <input type="submit" value="Submit">
        </form>
        <script>
            function validateForm() {
                var selectedFlight = document.querySelector('input[name="selectedFlight"]:checked');
                var agreementCheckbox = document.getElementById("agreementCheckbox");
                if (!selectedFlight) {
                    alert("Please select a flight");
                    return false;
                }
                if (!agreementCheckbox.checked) {
                    alert("Please accept the agreement to proceed");
                    return false;
                }
            }
        </script>
        <?php require '../includes/footer.php'; ?>
    </main>
</body>

</html>