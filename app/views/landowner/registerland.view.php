<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/landowner/registerlands.css">
    <title>Register Land</title>
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
					<form class="form" action="<?= URLROOT ?>/Landowner/registerland" method="POST"
						enctype="multipart/form-data">
						<div class="form-group">
							<label for="address">Address of the Land</label>
							<input type="text" id="address" name="address" required="">

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

							<label for="size">Size of the Land (In Sqm)</label>
							<input type="number" id="size" name="size" required="">
							
							<label for="duration">Time Period for the Lease (In Years)</label>
							<input type="number" id="duration" name="duration" required="">
							
							<label for="crop">Prefered Crop Type</label>
							<select id="cropType" name="crop_type" required>
								<option value="" disabled selected>Select a Crop Type</option>
								<option value="Rice">Rice</option>
								<option value="Wheat">Wheat</option>
								<option value="Maize">Maize</option>
								<option value="Potatoes">Potatoes</option>
								<option value="Tomatoes">Tomatoes</option>
								<option value="Onions">Onions</option>
								<option value="Coffee">Coffee</option>
								<option value="Sugarcane">Sugarcane</option>
							</select>


							Give a preffered date for the site visit
							<label for="date">date for scheduled visit</label>
							<input type="date" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
							
							<label for="doc">Upload a Legal Document of the Land</label>
							<input type="file" id="document" name="document" required>
							<h6>You Cannot Change the Details Again</h6>
							<button class="form-submit-btn" type="submit">
								<i class="fas fa-paper-plane"></i>&nbsp;Submit</button>
						</div>
					</form>
				</div>
			</div>

</body>
</html>
