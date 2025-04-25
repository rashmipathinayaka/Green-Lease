<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/sidebar.css">

	<title>Document</title>
</head>

<body>
	<div class="sidebar">
		<ul>
			<li>
				<img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
				<a href="<?php echo URLROOT; ?>/Supervisor/Index">Dashboard</a>
			</li>
			
            <li>
                <img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/supervisor/approve_land">Approve land</a>
            </li>

			<li>
				<img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
				<a href="<?php echo URLROOT; ?>/Supervisor/Manage_fertilizer">Manage Fertilizer</a>
			</li>
			<li>
				<img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
				<a href="<?php echo URLROOT; ?>/Supervisor/Manage_sitehead">Manage Site Heads</a>
			</li>
			
		
			<li>
				<img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
				<a href="<?php echo URLROOT; ?>/Supervisor/ManageIssues">Manage Issues</a>
			</li>
			<li>
				<img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
				<a href="<?php echo URLROOT; ?>/Supervisor/Site_Visit">Site visit</a>
			</li>

			<li>
				<img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
				<a href="<?php echo URLROOT; ?>/Supervisor/Event">Event Schedule</a>
			</li>
			<li>
				<img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
				<a href="<?php echo URLROOT; ?>/Supervisor/Attendance">Attendance</a>
			</li>
			<li>
				<img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
				<a href="<?php echo URLROOT; ?>/Supervisor/feedback">Manage Feedbacks</a>
			</li>
		</ul>
		<ul class="logout">
			<li><a href="/gl/logout.php">Log Out</a></li>
		</ul>
	</div>
</body>

</html>