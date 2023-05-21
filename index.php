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

	$searchResults = $flight->search($conn);
	if (!$searchResults) {
		$totalPersons = $flight->addPeople($conn);
	}
	
}

?>

<?php require 'includes/flight-form.php'; ?>

<?php if (!empty($searchResults)): ?>
		<?php require 'includes/search-result.php'; ?>	
	<?php else: ?>
		<h3>No Results Found</h3>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>