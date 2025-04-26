<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/landowner/registerlands.css">
    <title>Register Land</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
   
</head>

<body>
    <?php
    require ROOT . '/views/landowner/sidebar.php';
    require ROOT . '/views/components/topbar.php';
    ?>

    <div id="register-lands-section" class="section">
        <div class="form-container">
            <h1 class="register-topic">Register Your Land</h1>
            <br>
            <form class="form" action="<?= URLROOT ?>/Landowner/registerland" method="POST" enctype="multipart/form-data">
                <div class="form-group">

                    <label for="address">Address of the Land</label>
                    <input type="text" id="address" name="address" required pattern=".*,.*" title="check the address again" placeholder="Enter the address (must contain at least one comma)">

                    <!-- MAP + Coordinates -->
                    <div id="map" style="height: 400px;"></div>
                    <div id="map-error" style="color: red; margin-top: 5px; display: none;">
                        Please select a location on the map.
                    </div>

                    <label for="latitude">Latitude</label>
                    <input type="number" id="latitude" name="latitude" step="any" readonly placeholder="Latitude" required>

                    <label for="longitude">Longitude</label>
                    <input type="number" id="longitude" name="longitude" step="any" readonly placeholder="Longitude" required>

                    <label for="district">District</label>
                    <select name="zone_id" id="district" required>
                        <option value="" disabled selected>Select a district</option>
                        <?php foreach ($zones as $zone): ?>
                            <option value="<?= $zone->id ?>"><?= htmlspecialchars($zone->zone_name) ?></option>
                        <?php endforeach; ?>
                    </select>


                    <!-- Size -->
                    <label for="size">Size of the Land (In Sqm)</label>
                    <input type="number" id="size" name="size" required>

                    <!-- Duration -->
                    <label for="duration">Time Period for the Lease (In Years)</label>
                    <input type="number" id="duration" name="duration" required>

                    <!-- Crop -->
                    <label for="crop">Preferred Crop Type</label>
                    <div class="district">Crop types used in the system are shown below. You can select one of them or type a new crop name.</div>
                    <input list="cropType" name="crop_type" id="crop" required placeholder="Select or type a crop" autocomplete="off">
                    <datalist id="cropType">
                        <?php foreach ($crop_types as $crop): ?>
                            <option value="<?= htmlspecialchars($crop->crop_type) ?>">
                                <?php
                                // Display crop name and status text (don't repeat the crop name)
                                if ($crop->is_new == 1) {
                                    echo ' - Recently Added';
                                } else {
                                    echo ' - System Saved';
                                }
                                ?>
                            </option>
                        <?php endforeach; ?>
                    </datalist>


                    <!-- Date Range -->
                    <div class="date">Give a preferred date range for the site visit</div>
                    <label for="from_date">From:</label>
                    <input type="date" id="from_date" name="from_date" required min="<?php echo date('Y-m-d'); ?>">

                    <br>
                    <label for="to_date">To:</label>
                    <input type="date" id="to_date" name="to_date" required min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+21 days')); ?>">

                    <!-- Document Upload -->
                    <label for="doc">Upload a Legal Document of the Land</label>
                    <input type="file" id="document" name="document" required>

                    <h6>You Cannot Change the Details Again</h6>
                    <button class="form-submit-btn" type="submit">
                        <i class="fas fa-paper-plane"></i>&nbsp;Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="rmodal">
        <div class="modal-content">
            <span id="close-modal" class="rclose">&times;</span>
            <h2>Are you sure you want to submit the land registration details?</h2>
            <button id="confirm-btn">Yes, Submit</button>
            <button id="cancel-btn">Cancel</button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([6.9271, 79.8612], 10); // Default view: Colombo

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let marker;

        map.on('click', function (e) {
            const { lat, lng } = e.latlng;
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }

            marker.bindPopup(`Selected Location:<br>Lat: ${lat.toFixed(5)}, Lng: ${lng.toFixed(5)}`).openPopup();

            // Hide error message after a valid selection
            document.getElementById('map-error').style.display = 'none';
        });

        document.addEventListener('DOMContentLoaded', function () {
            const fromDateInput = document.getElementById('from_date');
            const toDateInput = document.getElementById('to_date');
            const form = document.querySelector('form');
            const confirmationModal = document.getElementById('confirmation-modal');
            const confirmBtn = document.getElementById('confirm-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const closeModal = document.getElementById('close-modal');

            // Update the 'to date' min value based on the 'from date'
            fromDateInput.addEventListener('change', function () {
                toDateInput.min = this.value;

                // If 'to date' is earlier than 'from date', reset 'to date'
                if (toDateInput.value && new Date(toDateInput.value) < new Date(this.value)) {
                    toDateInput.value = '';
                }
            });

            // Handle form submission
            form.addEventListener('submit', function (e) {
                const lat = document.getElementById('latitude').value;
                const lng = document.getElementById('longitude').value;
                const fromDate = fromDateInput.value;
                const toDate = toDateInput.value;
                const mapError = document.getElementById('map-error');

                mapError.style.display = 'none'; // Reset error visibility

                // Map validation: Ensure location is selected on the map
                if (!lat || !lng) {
                    e.preventDefault();
                    mapError.style.display = 'block';
                    return;
                }

                // Date validation: Ensure 'to date' is after 'from date'
                if (new Date(toDate) <= new Date(fromDate)) {
                    e.preventDefault();
                    alert('"To Date" must be after "From Date"!');
                    return;
                }

                // Show the confirmation modal
                confirmationModal.style.display = 'block';

                // If user confirms submission
                confirmBtn.addEventListener('click', function () {
                    form.submit(); // Proceed with form submission
                });

                // If user cancels submission
                cancelBtn.addEventListener('click', function () {
                    confirmationModal.style.display = 'none'; // Close the modal and keep the user on the page
                });

                // Close the modal if the user clicks the close button
                closeModal.addEventListener('click', function () {
                    confirmationModal.style.display = 'none';
                });

                // Prevent form submission initially
                e.preventDefault();
            });
        });
    </script>
</body>

</html>
