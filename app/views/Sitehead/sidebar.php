<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/sidebar.css">
	<title>Document</title>
</head>

<body>
	<!-- Hamburger Menu Toggle Button -->

	<!-- Sidebar -->
	<div class="sidebar" id="sidebar">
		<ul>
			<li>
				<img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
				<a href="<?php echo URLROOT; ?>/Sitehead/index">Dashboard</a>
			</li>
			<li>
				<img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
				<a href="<?php echo URLROOT; ?>/Sitehead/Manage_worker">Manage Workers</a>
			</li>
			<li>
				<img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
				<a href="<?php echo URLROOT; ?>/Sitehead/Manage_fertilizer">Request Fertilizers</a>
			</li>
			<li>
				<img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
				<a href="<?php echo URLROOT; ?>/Sitehead/Manage_fertilizer/requests">Fertilizer Requests Log</a>
			</li>
			<!-- <li>
				<img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
				<a href="<?php echo URLROOT; ?>/Sitehead/Attendance">Mark Attendance</a>
			</li> -->
			<li>
				<img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
				<a href="<?php echo URLROOT; ?>/Sitehead/ReportIssue">Report an Issue</a>
			</li>
		</ul>

		<!-- Logout Section -->
		<ul class="logout">
			<li>
				<img src="<?= URLROOT ?>/assets/images/logout.png" alt="Logout Icon" class="menu-icon">
				<a href="<?php echo URLROOT; ?>/logout">Log Out</a>
			</li>
		</ul>

	</div>

	<button class="menu-btn" onclick="toggleSidebar()">☰</button>
	<!-- JavaScript for Sidebar Toggle -->
	<script>
		function toggleSidebar() {
			const sidebar = document.getElementById("sidebar");
			sidebar.classList.toggle("active");
		}
	</script>
</body>

</html>