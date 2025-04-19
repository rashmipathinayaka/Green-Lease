<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/supervisor.css">

    <title>Document</title>
</head>
<body>
<?php
require ROOT . '/views/supervisor/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>
<div id="manage-issues-section" class="section">
					<!-- Tab Navigation -->
					<div class="tab-navigation">
						<button class="tab-btn active" onclick="switchTabs('pending-issues')">Pending Issues</button>
						<button class="tab-btn" onclick="switchTabs('solved-issues')">Solved Issues</button>
					</div>
					<!-- Handle Request Tab -->
					<div id="pending-issues" class="tab-content active">
						<!-- <h2>Fertilizer Requests</h2> -->
						<table class="dashboard-table">
							<thead>
								<tr>
									<th>Land ID</th>
									<th>Crop Type</th>
									<th>Bidder's Name</th>
									<th>Bidding Amount</th>
									<th>Percentage of the Harvest</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>L001</td>
									<td>Rice</td>
									<td>John Doe</td>
									<td>LKR 5000</td>
									<td>20%</td>
									<td>
										<button class="green-btn">Accept</button>
										<button class="red-btn">Reject</button>
									</td>
								</tr>
								<!-- Previous table rows can be added here -->
							</tbody>
						</table>
					</div>
					<div id="solved-issues" class="tab-content active" style="display:none;">
						<!-- <h2>Fertilizer Requests</h2> -->
						<table class="dashboard-table">
							<thead>
								<tr>
									<th>Land ID</th>
									<th>Crop Type</th>
									<th>Bidder's Name</th>
									<th>Bidding Amount</th>
									<th>Percentage of the Harvest</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>L001</td>
									<td>Rice</td>
									<td>John Doe</td>
									<td>LKR 5000</td>
									<td>20%</td>
									<td>
										<button class="green-btn">Accept</button>
										<button class="red-btn">Reject</button>
									</td>
								</tr>
								<!-- Previous table rows can be added here -->
							</tbody>
						</table>
					</div>
				</div>
</body>
</html>