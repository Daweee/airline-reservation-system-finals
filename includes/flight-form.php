<link rel="stylesheet" href="./css/index.css">


<div class="bg-image-1">
    <div class="text-block">
        <h2>More than just the destination</h2>
        <p>Earn Mabuhay Miles and Other Promos.</p>
    </div>
</div>
<div class="bg-image-2">
    <div class="text-block-2">
        <h2>Know Your Flight</h2>
        <p>The latest flight updates to keep you in charge of your trip.</p>
    </div>
</div>



<?php if (!empty($flight->errors)) : ?>
    <ul>
        <?php foreach ($flight->errors as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post">
    <div>
        <label for="flighttype">Flight Type:</label>
        <select name="flighttype" id="flighttype">
            <option value="roundtrip">Round trip</option>
            <option value="oneway">One way</option>
        </select>
    </div>

    <div>
        <label for="adults">Adults (12+ years):</label>
        <select name="adults" id="adults">
            <?php
            for ($i = 0; $i <= 10; $i++) {
                echo '<option value="' . $i . '">' . $i . '</option>';
            }
            ?>
        </select>
    </div>

    <div>
        <label for="children">Children (2-11 years):</label>
        <select name="children" id="children">
            <!-- Options will be added dynamically using JavaScript -->
        </select>
    </div>

    <div>
        <label for="infants">Infants (under 2 years):</label>
        <select name="infants" id="infants">
            <!-- Options will be added dynamically using JavaScript -->
        </select>
    </div>

    <div>
        <label for="origin">From:</label>
        <select name="origin">
            <option value="Cebu">Cebu</option>
            <option value="Manila">Manila</option>
            <option value="Davao">Davao</option>
        </select>
    </div>

    <div>
        <label for="destination">To:</label>
        <select name="destination">
            <option value="Manila">Manila</option>
            <option value="Cebu">Cebu</option>
            <option value="Davao">Davao</option>
        </select>
    </div>

    <div>
        <label for="depart">Depart Date:</label>
        <input type="date" id="depart" name="depart">
    </div>

    <div id="returnDateContainer">
        <label for="return">Return Date:</label>
        <input type="date" id="return" name="return">
    </div>

    <input type="submit" value="Search">
</form>

<script>
    var adultsSelect = document.getElementById('adults');
    var childrenSelect = document.getElementById('children');
    var infantsSelect = document.getElementById('infants');

    adultsSelect.addEventListener('change', updateSlots);

    function updateSlots() {
        var selectedAdults = parseInt(adultsSelect.value);
        var remainingSlots = 10 - selectedAdults;

        childrenSelect.innerHTML = '';
        infantsSelect.innerHTML = '';

        for (var i = 0; i <= remainingSlots; i++) {
            var option = document.createElement('option');
            option.value = i;
            option.text = i;
            childrenSelect.appendChild(option);
        }

        for (var i = 0; i <= remainingSlots; i++) {
            var option = document.createElement('option');
            option.value = i;
            option.text = i;
            infantsSelect.appendChild(option);
        }
    }

    updateSlots();
</script>