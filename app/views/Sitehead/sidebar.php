<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/buyer.css">
	<title>Document</title>
</head>

<body>
	<!-- Hamburger Menu Toggle Button -->

	<!-- Sidebar -->
	<div class="sidebar" id="sidebar">
		<ul>
			<li>
				<a href="<?php echo URLROOT; ?>/Sitehead/index">Dashboard</a>
			</li>
			<li>
				<a href="<?php echo URLROOT; ?>/Sitehead/Manage_worker">Manage Workers</a>
			</li>
			<li>
				<a href="<?php echo URLROOT; ?>/Sitehead/Manage_fertilizer">Request Fertilizers</a>
			</li>
			<li>
				<a href="<?php echo URLROOT; ?>/Sitehead/Manage_fertilizer/requests">Fertilizer Requests Log</a>
			</li>
			<!-- <li>
				<a href="<?php echo URLROOT; ?>/Sitehead/Attendance">Mark Attendance</a>
			</li> -->
			<li>
				<a href="<?php echo URLROOT; ?>/Sitehead/ReportIssue">Report an Issue</a>
			</li>

			<li>
				<a href="<?php echo URLROOT; ?>/sitehead/feedback">Manage Feedbacks</a>
			</li>

			<li>
				<a href="<?php echo URLROOT; ?>/sitehead/project_completion">Complete project</a>
			</li>

		</ul>

		<!-- Logout Section -->
		<ul class="logout">
			<li>
				<a href="<?php echo URLROOT; ?>/logout">Log Out</a>
			</li>
		</ul>

	</div>

	<!-- <button class="menu-btn" onclick="toggleSidebar()">☰</button> -->
	<!-- JavaScript for Sidebar Toggle -->
	<script>
		function toggleSidebar() {
			const sidebar = document.getElementById("sidebar");
			sidebar.classList.toggle("active");
		}
	</script>
</body>

</html>