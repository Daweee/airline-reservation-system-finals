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

  // return flight is automatically selected together with the flight ID
  if (isset($_POST['returning_flight_ids'])) {
    // Retrieve the selected return flight ID
    $selectedReturnFlightID = $_POST['returning_flight_ids'];

    // Store the return flight ID in the session for future use
    $_SESSION['returning_flight_ids'] = $selectedReturnFlightID;
  }
}

?>

<head>
  <link rel="stylesheet" type="text/css" href="../css/guestdetails.css">
</head>

<?php
  $adults = $_SESSION['adults'];
  $children = $_SESSION['children'];
  $infants = $_SESSION['infants'];
?>

<div>
  <form action="/airline-reservation-system-finals-clone/airline-reservation-system-finals/includes/booking-summary.php" method="POST">
    <?php for ($i = 1; $i <= $adults; $i++) { ?>
      <div>
        <div id="collapseIcon" onclick="toggleForm(<?php echo $i; ?>)">
          Adult number <?php echo $i; ?>▼   <!--ILISDIG ICON IF MAKAYA HUHU-->
        </div>
          <div id="guestForm<?php echo $i; ?>" class="guestForm collapsed">
            <h2>Guest <?php echo $i; ?> Details</h2>
            <label for="guestTitle<?php echo $i; ?>">Title:</label>
            <select id="guestTitle<?php echo $i; ?>" name="guests[<?php echo $i; ?>][title]">
              <option value="Mr.">Mr.</option>
              <option value="Mrs.">Mrs.</option>
              <option value="Miss">Miss</option>
              <option value="Ms.">Ms.</option>
            </select>
            <br>
            <label for="guestLastName<?php echo $i; ?>">Last Name:</label>
            <input type="text" id="guestLastName<?php echo $i; ?>" name="guests[<?php echo $i; ?>][lastName]" required>
            <br>
            <label for="guestFirstName<?php echo $i; ?>">First Name:</label>
            <input type="text" id="guestFirstName<?php echo $i; ?>" name="guests[<?php echo $i; ?>][firstName]" required>
            <br>
            <label for="guestMiddleName<?php echo $i; ?>">Middle Name:</label>
            <input type="text" id="guestMiddleName<?php echo $i; ?>" name="guests[<?php echo $i; ?>][middleName]" required>
            <br>
            <label for="guestBirthDate<?php echo $i; ?>">Birth date:</label>
            <input type="date" id="guestBirthDate<?php echo $i; ?>" name="guests[<?php echo $i; ?>][birthDate]" required>

            <h2>Contact Details</h2>
            <br>
            <label for="streetAddress<?php echo $i; ?>">Street Address:</label>
            <input type="text" id="streetAddress<?php echo $i; ?>" name="guests[<?php echo $i; ?>][streetAddress]" required>
            <br>
            <label for="city<?php echo $i; ?>">City:</label>
            <input type="text" id="city<?php echo $i; ?>" name="guests[<?php echo $i; ?>][city]" required>
            <br>
            <label for="zipCode<?php echo $i; ?>">Zip Code:</label>
            <input type="text" id="zipCode<?php echo $i; ?>" name="guests[<?php echo $i; ?>][zipCode]" required>
            <br>
            <label for="country<?php echo $i; ?>">Country:</label>
            <input type="text" id="country<?php echo $i; ?>" name="guests[<?php echo $i; ?>][country]" required>
            <br>
            <label for="homePhone<?php echo $i; ?>">Home Phone:</label>
            <input type="tel" id="homePhone<?php echo $i; ?>" name="guests[<?php echo $i; ?>][homePhone]" required>
            <br>
            <label for="workPhone<?php echo $i; ?>">Work Phone:</label>
            <input type="tel" id="workPhone<?php echo $i; ?>" name="guests[<?php echo $i; ?>][workPhone]">
            <br>
            <label for="fax<?php echo $i; ?>">Fax:</label>
            <input type="tel" id="fax<?php echo $i; ?>" name="guests[<?php echo $i; ?>][fax]">
            <br>
            <label for="mobilePhone<?php echo $i; ?>">Mobile Phone:</label>
            <input type="tel" id="mobilePhone<?php echo $i; ?>" name="guests[<?php echo $i; ?>][mobilePhone]" required>
            <br>
            <label for="emailAddress<?php echo $i; ?>">Email Address:</label>
            <input type="email" id="emailAddress<?php echo $i; ?>" name="guests[<?php echo $i; ?>][emailAddress]" required>
            <br>
            <label for="confirmEmail<?php echo $i; ?>">Confirm Email:</label>
            <input type="email" id="confirmEmail<?php echo $i; ?>" name="guests[<?php echo $i; ?>][confirmEmail]" required> <br>
          </div>
      </div>
    <?php } ?>

    <?php for ($i = 1; $i <= $children; $i++) { ?>
      <div>
        <div id="collapseIcon" onclick="toggleForm(<?php echo $i + $adults; ?>)">
          Child number <?php echo $i; ?>▼
        </div>
        <div id="guestForm<?php echo $i + $adults; ?>" class="guestForm collapsed">
          <h2>Child <?php echo $i; ?> Details</h2>
          <label for="guestTitle<?php echo $i + $adults; ?>">Title:</label>
          <select id="guestTitle<?php echo $i + $adults; ?>" name="guests[<?php echo $i + $adults; ?>][title]">
            <option value="Mr.">Mr.</option>
            <option value="Mrs.">Mrs.</option>
            <option value="Miss">Miss</option>
            <option value="Ms.">Ms.</option>
          </select>
          <br>
          <label for="childFirstName<?php echo $i + $adults; ?>">First Name:</label>
          <input type="text" id="childFirstName<?php echo $i + $adults; ?>" name="guests[<?php echo $i + $adults; ?>][firstName]" required>
          <br>
          <label for="childLastName<?php echo $i + $adults; ?>">Last Name:</label>
          <input type="text" id="childLastName<?php echo $i + $adults; ?>" name="guests[<?php echo $i + $adults; ?>][lastName]" required>
          <br>
          <label for="childMiddleName<?php echo $i + $adults; ?>">Middle Name:</label>
          <input type="text" id="childMiddleName<?php echo $i + $adults; ?>" name="guests[<?php echo $i + $adults; ?>][middleName]" required>
          <br>
          <label for="childBirthDate<?php echo $i + $adults; ?>">Birth Date:</label>
          <input type="date" id="childBirthDate<?php echo $i + $adults; ?>" name="guests[<?php echo $i + $adults; ?>][birthDate]" required>
          
        </div>
      </div>
    <?php } ?>

    <?php for ($i = 1; $i <= $infants; $i++) { ?>
      <div>
        <div id="collapseIcon" onclick="toggleForm(<?php echo $i + $adults + $children; ?>)">
          Infant number <?php echo $i; ?>▼
        </div>
        <div id="guestForm<?php echo $i + $adults + $children; ?>" class="guestForm collapsed">
          <h2>Infant <?php echo $i; ?> Details</h2>
          <label for="guestTitle<?php echo $i + $adults + $children; ?>">Title:</label>
          <select id="guestTitle<?php echo $i + $adults + $children; ?>" name="guests[<?php echo $i + $adults + $children; ?>][title]">
            <option value="Mr.">Mr.</option>
            <option value="Mrs.">Mrs.</option>
            <option value="Miss">Miss</option>
            <option value="Ms.">Ms.</option>
          </select>
          <br>
          <label for="infantFirstName<?php echo $i + $adults + $children; ?>">First Name:</label>
          <input type="text" id="infantFirstName<?php echo $i + $adults + $children; ?>" name="guests[<?php echo $i + $adults + $children; ?>][firstName]" required>
          <br>
          <label for="infantLastName<?php echo $i + $adults + $children; ?>">Last Name:</label>
          <input type="text" id="infantLastName<?php echo $i + $adults + $children; ?>" name="guests[<?php echo $i + $adults + $children; ?>][lastName]" required>
          <br>
          <label for="infantMiddleName<?php echo $i + $adults + $children; ?>">Middle Name:</label>
          <input type="text" id="infantMiddleName<?php echo $i + $adults + $children; ?>" name="guests[<?php echo $i + $adults + $children; ?>][middleName]" required>
          <br>
          <label for="infantBirthDate<?php echo $i + $adults + $children; ?>">Birth Date:</label>
          <input type="date" id="infantBirthDate<?php echo $i + $adults + $children; ?>" name="guests[<?php echo $i + $adults + $children; ?>][birthDate]" required>
          
        </div>
      </div>
    <?php } ?>

    <input type="submit" value="Submit">
  </form>
</div>

<script>
  function toggleForm(formIndex) {
    var forms = document.getElementsByClassName("guestForm");
    for (var i = 0; i < forms.length; i++) {
      if (i === formIndex - 1) {
        forms[i].classList.toggle("collapsed");
      } else {
        forms[i].classList.add("collapsed");
      }
    }
  }
</script>