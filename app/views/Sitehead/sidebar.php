<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/sitehead.css">

	<title>Document</title>
</head>

<body>
	<div class="sidebar">
		<ul>
			<li><a href="<?php echo URLROOT; ?>/Sitehead/index">Dashboard</a></li>
			<li><a href="<?php echo URLROOT; ?>/Sitehead/Manage_worker">Manage Workers</a></li>
			<li><a href="<?php echo URLROOT; ?>/Sitehead/Manage_fertilizer">Request Fertilizers</a></li>
			<li><a href="<?php echo URLROOT; ?>/Sitehead/Attendance">Mark Attendance</a></li>
			<li><a href="<?php echo URLROOT; ?>/Sitehead/ReportIssue">Report an Issue</a></li>
		</ul>
		<ul class="logout">
			<li><a href="/gl/logout.php">Log Out</a></li>
		</ul>
	</div>
</body>

</html>