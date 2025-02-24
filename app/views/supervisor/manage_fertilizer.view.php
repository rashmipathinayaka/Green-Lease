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
require ROOT . '/views/components/navbar.php';
?>
<div id="manage-fertilizer-section" >
					<!-- Tab Navigation -->
					<div class="tab-navigation">
						<button class="tab-btn active" onclick="switchTab('handle-request')">Handle Request</button>
						<button class="tab-btn" onclick="switchTab('stock-management')">Stock Management</button>
					</div>
					<!-- Handle Request Tab -->
					<div id="handle-request" class="tab-content active">
						<center>
							<h1>Fertilizer Requests</h1>
						</center>
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
					<!-- Stock Management Tab -->
					<div id="stock-management" class="tab-content" style="display:none;">
						<div class="metric-grid">
							<div class="metric-card">
								<h3>Total Fertilizer Stock</h3>
								<div class="metric-content">
									<span class="metric-value">1,250 kg</span>
									<i class="fas fa-box-open"></i>
								</div>
							</div>
							<div class="metric-card">
								<h3>Most Used Fertilizer</h3>
								<div class="metric-content">
									<span class="metric-value">NPK 15-15-15</span>
									<i class="fas fa-chart-pie"></i>
								</div>
							</div>
							<div class="metric-card">
								<h3>Low Stock Alerts</h3>
								<div class="metric-content">
									<span class="metric-value">3</span>
									<i class="fas fa-exclamation-triangle"></i>
								</div>
							</div>
							<div class="metric-card">
								<h3>Recent Purchases</h3>
								<div class="metric-content">
									<span class="metric-value">12</span>
									<i class="fas fa-shopping-cart"></i>
								</div>
							</div>
						</div>
						<center>
							<h1>Fertilizer Inventory</h1>
						</center>
						<table class="dashboard-table">
							<thead>
								<tr>
									<th>Fertilizer Type</th>
									<th>Current Stock</th>
									<th>Reorder Level</th>
									<th>Last Restocked</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>NPK 15-15-15</td>
									<td>350 kg</td>
									<td>250 kg</td>
									<td>2024-03-15</td>
									<td>
										<button class="green-btn">Restock</button>
										<button class="blue-btn">Details</button>
									</td>
								</tr>
								<tr>
									<td>Urea</td>
									<td>200 kg</td>
									<td>150 kg</td>
									<td>2024-02-28</td>
									<td>
										<button class="green-btn">Restock</button>
										<button class="blue-btn">Details</button>
									</td>
								</tr>
								<tr>
									<td>Phosphate</td>
									<td>100 kg</td>
									<td>75 kg</td>
									<td>2024-03-10</td>
									<td>
										<button class="green-btn">Restock</button>
										<button class="blue-btn">Details</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
</body>
</html>