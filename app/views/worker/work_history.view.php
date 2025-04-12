<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Worker Dashboard</title>
		<link rel="stylesheet" href="<?= URLROOT; ?>/assets/css/worker.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
		<!-- <script src="worker.js" defer></script> -->
	</head>
	<body>

	<?php
require ROOT . '/views/worker/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>

<div id="work-history-section" class="section">
					<center>
						<h1>Work History</h1>
					</center>
					<!-- Search and Filter Section
						<div class="filter-section">
						    <select id="status-filter">
						        <option value="">All Status</option>
						        <option value="active">Active</option>
						        <option value="inactive">Inactive</option>
						    </select>
						</div> -->
					<!-- Supervisors Table -->
					<table class="dashboard-table">
						<thead>
							<tr>
								<th>Land Location</th>
								<th>Hours Worked</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody id="supervisor-list">
							<tr>
								<td>Green Valley Farm</td>
								<td>8</td>
								<td>2024-11-21</td>
							</tr>
							<tr>
								<td>Sunny Acres</td>
								<td>6</td>
								<td>2024-11-20</td>
							</tr>
							<tr>
								<td>Hillside Plantation</td>
								<td>7</td>
								<td>2024-11-19</td>
							</tr>
							<tr>
								<td>Riverside Orchards</td>
								<td>5</td>
								<td>2024-11-18</td>
							</tr>
							<tr>
								<td>Golden Fields</td>
								<td>9</td>
								<td>2024-11-17</td>
							</tr>
						</tbody>
					</table>
				</div>
	</body>
</html>