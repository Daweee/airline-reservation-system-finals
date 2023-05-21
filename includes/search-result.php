<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
		<h1>Results:</h1>
	</header>
	<main>
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
            <?php if ($searchResults !== null && count($searchResults) > 0): ?>
                <?php foreach ($searchResults as $result): ?>
                    <tr>
                        <td><?= $result->flight_id ?></td>
                        <td><?= $result->origin ?></td>
                        <td><?= $result->destination ?></td>
                        <td><?= $result->departure_date ?></td>
                        <td><?= ($result->return_date !== '0000-00-00') ? $result->return_date : "NULL" ?></td>
                        <td><?= $result->flight_type ?></td>
                        <td>
                            <input type="radio" name="selectedFlight" value="<?= $result->flight_id ?>" onclick="pickFlight(<?= $result->flight_id ?>)">
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

<?php require 'includes/footer.php'; ?>