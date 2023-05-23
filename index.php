<?php

require 'includes/init.php';

$conn = require 'includes/db.php';

?>

<?php require 'includes/header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/index.css">

<?php if (Auth::isLoggedIn()) : ?>
	<p class="logged-in">You are logged in. <a href="logout.php">Log out</a></p>
<?php else : ?>
	<p class="guest">You are a guest. You are not logged in. <a href="login.php">Log in</a></p>
<?php endif; ?>

<?php

$flight = new Flights();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$conn = require 'includes/db.php';

	$flight->userAdults = isset($_POST['adults']) ? $_POST['adults'] : '';
	$flight->userChildren = isset($_POST['children']) ? $_POST['children'] : '';
	$flight->userInfants = isset($_POST['infants']) ? $_POST['infants'] : '';
	$flight->userFlightType = isset($_POST['flighttype']) ? $_POST['flighttype'] : '';
	$flight->userOrigin = isset($_POST['origin']) ? $_POST['origin'] : '';
	$flight->userDestination = isset($_POST['destination']) ? $_POST['destination'] : '';
	$flight->userDepartDate = isset($_POST['depart']) ? $_POST['depart'] : '';
	$flight->userReturnDate = isset($_POST['return']) ? $_POST['return'] : '';

	$_SESSION['adults'] = $flight->userAdults;
	$_SESSION['children'] = $flight->userChildren;
	$_SESSION['infants'] = $flight->userInfants;

	$searchResults = $flight->search($conn);

	
	

}

?>

<?php require 'includes/flight-form.php'; ?>

<?php if (!empty($searchResults)) : ?>
	<div class="search-results">
		<h2>Search Results:</h2>
		<form action="" method="post">
			<ul>
				<?php foreach ($searchResults as $result) : ?>
					<li>
						<input type="radio" name="selectedFlight" value="<?= $result->flight_id ?>">
						<h3>Flight ID: <?= $result->flight_id ?></h3>
						<p>Origin: <?= $result->origin ?></p>
						<p>Destination: <?= $result->destination ?></p>
						<p>Departure Date: <?= $result->departure_date ?></p>
						<p>Return Date: <?= ($result->return_date !== '0000-00-00') ? $result->return_date : "NULL" ?></p>
						<p>Flight Type: <?= $result->flight_type ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
			<button type="submit">Select Flight</button>
		</form>
	</div>
<?php else : ?>
	<h3>No Results Found</h3>
<?php endif; ?>


<?php require 'includes/footer.php'; ?>