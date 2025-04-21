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
					<input type="text" id="address" name="address" required pattern=".*,.*" title="Address must contain at least one comma" placeholder="Enter the address (must contain at least one comma)">

					<!-- MAP + Coordinates -->
					<div id="map" style="height: 400px;"></div>
					<label for="latitude">Latitude</label>
					<input type="number" id="latitude" name="latitude" step="any" readonly placeholder="Latitude">

					<label for="longitude">Longitude</label>
					<input type="number" id="longitude" name="longitude"step="any" readonly placeholder="Longitude">

					<!-- District -->
					<label for="district">District</label>
					<select id="district" name="district" required>
						<option value="" disabled selected>Select District</option>
						<option value="Matara">Matara</option>
						<option value="Galle">Galle</option>
						<option value="Hambanthota">Hambanthota</option>
						<option value="Colombo">Colombo</option>
						<option value="Anuradhapura">Anuradhapura</option>
						<option value="Badulla">Badulla</option>
						<option value="Gampaha">Gampaha</option>
						<option value="Sabaragamuwa">Sabaragamuwa</option>
					</select>

					<!-- Size -->
					<label for="size">Size of the Land (In Sqm)</label>
					<input type="number" id="size" name="size" required>

					<!-- Duration -->
					<label for="duration">Time Period for the Lease (In Years)</label>
					<input type="number" id="duration" name="duration" required>

					<!-- Crop -->
					<label for="crop">Preferred Crop Type</label>
					<div class="note">Crop types used in the system are shown below. You can select one of them or type a new crop name.</div>
					<input list="cropType" name="crop_type" id="crop" required placeholder="Select or type a crop" autocomplete="off">
					<datalist id="cropType">
						<?php foreach ($crop_types as $crop): ?>
							<option value="<?= htmlspecialchars($crop->crop_type) ?>">
						<?php endforeach; ?>
					</datalist>

					<!-- Date Range -->
					<div class="text">Give a preferred date range for the site visit</div>
					<label for="from_date">From:</label>
					<input type="date" id="from_date" name="from_date" required min="<?php echo date('Y-m-d'); ?>">

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
		});
	</script>

</body>
</html>
