<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check if a flight is selected
  if (isset($_POST['selectedFlight'])) {
    // Retrieve the selected flight ID
    $selectedFlightID = $_POST['selectedFlight'];

    // Store the flight ID in the session for future use
    $_SESSION['selectedFlightID'] = $selectedFlightID;
  }
}
?>

<head>
  <link rel="stylesheet" type="text/css" href="../css/guestdetails.css">
</head>

<form action="/airline-reservation-system-finals/includes/booking-summary.php" method="POST">
  <h2>Guest Details</h2>
  <label for="guestTitle">Title:</label>
  <select id="guestTitle" name="guestTitle">
    <option value="Mr.">Mr.</option>
    <option value="Mrs.">Mrs.</option>
    <option value="Miss">Miss</option>
    <option value="Ms.">Ms.</option>
  </select>
  <br>
  <label for="guestLastName">Last Name:</label>
  <input type="text" id="guestLastName" name="guestLastName" required>
  <br>
  <label for="guestFirstName">First Name:</label>
  <input type="text" id="guestFirstName" name="guestFirstName" required>
  <br>
  <label for="guestMiddleName">Middle Name:</label>
  <input type="text" id="guestMiddleName" name="guestMiddleName" required>
  <br>
  <label for="guestBirthDate">Birth date:</label>
  <input type="date" id="guestBirthDate" name="guestBirthDate" required>

  <h2>Contact Details</h2>
  <br>
  <label for="streetAddress">Street Address:</label>
  <input type="text" id="streetAddress" name="streetAddress" required>
  <br>
  <label for="city">City:</label>
  <input type="text" id="city" name="city" required>
  <br>
  <label for="zipCode">Zip Code:</label>
  <input type="text" id="zipCode" name="zipCode" required>
  <br>
  <label for="country">Country:</label>
  <input type="text" id="country" name="country" required>
  <br>
  <label for="homePhone">Home Phone:</label>
  <input type="tel" id="homePhone" name="homePhone" required>
  <br>
  <label for="workPhone">Work Phone:</label>
  <input type="tel" id="workPhone" name="workPhone">
  <br>
  <label for="fax">Fax:</label>
  <input type="tel" id="fax" name="fax">
  <br>
  <label for="mobilePhone">Mobile Phone:</label>
  <input type="tel" id="mobilePhone" name="mobilePhone" required>
  <br>
  <label for="emailAddress">Email Address:</label>
  <input type="email" id="emailAddress" name="emailAddress" required>
  <br>
  <label for="confirmEmail">Confirm Email:</label>
  <input type="email" id="confirmEmail" name="confirmEmail" required> <br>

  <input type="hidden" name="selectedFlightID" value="<?php echo isset($_SESSION['selectedFlightID']) ? $_SESSION['selectedFlightID'] : ''; ?>">

  <input type="submit" value="Submit">
</form>