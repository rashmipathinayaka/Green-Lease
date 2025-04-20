<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/sitehead.css">

	<title>Document</title>
</head>

<body>


	<?php
	require ROOT . '/views/sitehead/sidebar.php';
	require ROOT . '/views/components/topbar.php';
	?>
	<div id="mark-attendance-section" class="section">
		<div class="header">
			<center>
				<h1>Worker Attendance Tracker</h1>
			</center>
			<br>
			<div class="date-container">
				<span class="date-label">Date:</span>
				<input type="date" class="date-picker" value="2024-11-23">
			</div>
		</div>
		<div class="attendance-form">
			<table class="dashboard-table">
				<thead>
					<tr>
						<th>Worker ID</th>
						<th>Name</th>
						<th>Status</th>
						<th>Check-in Time</th>
						<th>Check-out Time</th>
					</tr>
				</thead>
				<tbody id="supervisor-list">
					<tr>
						<td>W001</td>
						<td>Kamal Perera</td>
						<td>
							<select class="status-select">
								<option value="present">Present</option>
								<option value="absent">Absent</option>
								<option value="late">Late</option>
								<option value="leave">Leave</option>
							</select>
						</td>
						<td><input type="time" class="time-input"></td>
						<td><input type="time" class="time-input"></td>
					</tr>
					<tr>
						<td>W002</td>
						<td>Janeesh Kulathunge</td>
						<td>
							<select class="status-select">
								<option value="present">Present</option>
								<option value="absent">Absent</option>
								<option value="late">Late</option>
								<option value="leave">Leave</option>
							</select>
						</td>
						<td><input type="time" class="time-input"></td>
						<td><input type="time" class="time-input"></td>
					</tr>
					<tr>
						<td>W003</td>
						<td>Mike Silva</td>
						<td>
							<select class="status-select">
								<option value="present">Present</option>
								<option value="absent">Absent</option>
								<option value="late">Late</option>
								<option value="leave">Leave</option>
							</select>
						</td>
						<td><input type="time" class="time-input"></td>
						<td><input type="time" class="time-input"></td>
					</tr>
				</tbody>
			</table>
			<center><button class="green-btn">Save Attendance</button></center>
		</div>
	</div>
</body>

</html>