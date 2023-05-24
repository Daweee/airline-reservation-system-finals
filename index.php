<?php

require 'includes/init.php';

$conn = require 'includes/db.php';

?>

<?php require 'includes/header.php'; ?>

<?php if (Auth::isLoggedIn()) : ?>
	<p>You are logged in. <a href="logout.php">Log out</a></p>
<?php else : ?>
	<p>You are a guest. You are not logged in. <a href="login.php">Log in</a></p>
<?php endif; ?>

<?php

$flight = new Flights();

if ($_SERVER["REQUEST_METHOD"] == "GET") {

	$conn = require 'includes/db.php';

	$flight->userAdults = isset($_GET['adults']) ? $_GET['adults'] : '';
	$flight->userChildren = isset($_GET['children']) ? $_GET['children'] : '';
	$flight->userInfants = isset($_GET['infants']) ? $_GET['infants'] : '';
	$flight->userFlightType = isset($_GET['flighttype']) ? $_GET['flighttype'] : '';
	$flight->userOrigin = isset($_GET['origin']) ? $_GET['origin'] : '';
	$flight->userDestination = isset($_GET['destination']) ? $_GET['destination'] : '';
	$flight->userDepartDate = isset($_GET['depart']) ? $_GET['depart'] : '';
	$flight->userReturnDate = isset($_GET['return']) ? $_GET['return'] : '';

	$_SESSION['adults'] = $flight->userAdults;
	$_SESSION['children'] = $flight->userChildren;
	$_SESSION['infants'] = $flight->userInfants;

	$searchResults = $flight->search($conn);
}

?>

<?php require 'includes/flight-form.php'; ?>

<?php if (!empty($searchResults)) : ?>
	<?php require 'includes/search-result.php'; ?>
<?php else : ?>
	<h3>No Results Found</h3>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>