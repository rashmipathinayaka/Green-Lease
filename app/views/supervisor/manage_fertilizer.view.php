<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/supervisor.css">
	<script>
		const URLROOT = "<?php echo URLROOT; ?>";
	</script>

	<script src="<?php echo URLROOT; ?>/assets/JS/supervisor.js" defer></script>
	<title>Document</title>
</head>

<body>
	<?php
	require ROOT . '/views/supervisor/sidebar.php';
	require ROOT . '/views/components/navbar.php';
	?>
	<div id="toastBox"></div>


	<div id="manage-fertilizer-section" class="section">
		<!-- Tab Navigation -->
		<div class="tab-navigation">
			<button class="tab-btn active" onclick="switchTabs(this, 'handle-request')">Handle Request</button>
			<button class="tab-btn" id="request-history-btn" onclick="switchTabs(this, 'request-history')">Request History</button>
			<button class="tab-btn" id="stock-management-btn" onclick="switchTabs(this, 'stock-management')">Stock Management</button>
		</div>
		<!-- Handle Request Tab -->
		<div id="handle-request" class="tab-content active">
			<center>
				<h1>Fertilizer Requests</h1>
			</center>
			<table class="dashboard-table">
				<thead>
					<tr>
						<th>Project ID</th>
						<th>Sitehead ID</th>
						<th>Type</th>
						<th>Amount(kg)</th>
						<th>Prefferrred Delivery Date</th>
						<th>Remarks</th>
						<th>actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($pendingrequests)) : ?>
						<?php foreach ($pendingrequests as $request) : ?>
							<tr>
								<td><?php echo htmlspecialchars($request->project_id); ?></td>
								<td><?php echo htmlspecialchars($request->sitehead_id); ?></td>
								<td><?php echo htmlspecialchars($request->type); ?></td>
								<td><?php echo htmlspecialchars($request->amount); ?></td>
								<td><?php echo htmlspecialchars($request->preferred_date); ?></td>
								<td><?php echo htmlspecialchars($request->remarks); ?></td>
								<td>
									<button class="green-btn" onclick="confirmAcceptRequest(<?php echo $request->id; ?>)">Accept</button>
									<button class="red-btn" onclick="confirmRejectRequest(<?php echo $request->id; ?>)">Reject</button>

								</td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="5">No fertilizer requests found.</td>
						</tr>
					<?php endif; ?>
				</tbody>

			</table>
		</div>

		<div id="request-history" class="tab-content" style="display:none;">
			<center>
				<h1>Handled Request History</h1>
			</center>
			<table class="dashboard-table">
				<thead>
					<tr>
						<th>Project ID</th>
						<th>Sitehead ID</th>
						<th>Type</th>
						<th>Amount</th>
						<th>Prefferrred Delivery Date</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($solvedrequests)) : ?>
						<?php foreach ($solvedrequests as $request) : ?>
							<tr>
								<td><?php echo htmlspecialchars($request->project_id); ?></td>
								<td><?php echo htmlspecialchars($request->sitehead_id); ?></td>
								<td><?php echo htmlspecialchars($request->type); ?></td>
								<td><?php echo htmlspecialchars($request->amount); ?></td>
								<td><?php echo htmlspecialchars($request->preferred_date); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="5">No handled requests found.</td>
						</tr>
					<?php endif; ?>
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