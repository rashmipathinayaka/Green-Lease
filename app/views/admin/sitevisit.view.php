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

require ROOT . '/views/admin/sidebar.php';
require ROOT . '/views/components/navbar.php';

?>

<div id="register-lands-section" class="section">
				<div class="form-container">
					<h1 class="register-topic">Schedule a site visit</h1>
					<br>
					<form class="form" action="<?= URLROOT ?>/Admin/sitevisit" method="POST"
						enctype="multipart/form-data">
						<div class="form-group">
							<label for="address">Land id</label>
							<input type="text" id="address" name="address" required="">

							<label for="district">suprevisor</label>
							<select id="district" name="district" required>
								<option value="" disabled selected>Select supervisor</option>
								<option value="Matara">01</option>
								<option value="Galle">02</option>
								<option value="Hambanthota">03</option>
								<option value="Colombo">04</option>
								<option value="Anuradhapura">05</option>
								<option value="Badulla">06</option>
								<option value="Gampaha">07</option>
								<option value="Sabaragamuwa">08</option>
							</select>

							<label for="size">date </label>
							<input type="number" id="size" name="size" required="">
							
							<label for="duration">time</label>
							<input type="number" id="duration" name="duration" required="">
							
							<label for="crop">Prefered Crop Type</label>
							
							
							<button class="form-submit-btn" type="submit">
								<i class="fas fa-paper-plane"></i>&nbsp;Schedule</button>
						</div>
					</form>
				</div>
			</div>

</body>
</html>
