<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/landowner/registerlands.css">
    <title>add supervisor</title>
</head>
<body>

<?php

require ROOT . '/views/components/topbar.php';

?>



<div id="register-lands-section" class="section">
				<div class="form-container">
					<h1 class="register-topic">Fill in supervisor details</h1>
					<br>
					<form class="form" action="<?= URLROOT ?>/Admin/add_supervisor" method="POST"
						enctype="multipart/form-data">
						<div class="form-group">
                        <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="contact_no">Phone Number:</label>
                <input type="number" id="contact_no" name="contact_no" required>
                <label for="nic">NIC:</label>
                <input type="number" id="nic" name="nic" required>
                <label for="zone">Zone:</label>
                <select id="zone" name="zone" required>
                    <option value="1">Zone 1</option>
                    <option value="2">Zone 2</option>
                    <option value="3">Zone 3</option>
                    <option value="4">Zone 4</option>
                </select>
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="0">Active</option>
                    <option value="1">Inactive</option>
                </select>
							<button class="form-submit-btn" type="submit">
								<i class="fas fa-paper-plane"></i>&nbsp;Submit</button>
                                <button class="black-btn" onclick="window.location.href='<?= URLROOT ?>/Admin/manage_supervisor/'">Go back</button>


						</div>
					</form>
				</div>
			</div>








