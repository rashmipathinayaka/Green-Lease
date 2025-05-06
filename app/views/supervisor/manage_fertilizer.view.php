<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/supervisor.css">
	<script>
		const URLROOT = "<?php echo URLROOT; ?>";
	</script>

	<script src="<?php echo URLROOT; ?>/assets/JS/supervisor.js" defer></script>
	<title>Document</title>
</head>

<body style="margin-top: 100px; margin-left: 20px; margin-right: 20px;">
	<?php
	require ROOT . '/views/supervisor/sidebar.php';
	require ROOT . '/views/components/topbar.php';
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
						<th>Sitehead <br> Name</th>
						<th>Contact No.</th>
						<th>Crop type</th>
						<th>Requested <br> Fertilizer Type</th>
						<th>Amount(kg)</th>
						<th>Prefferrred <br> Delivery Date</th>
						<th>Remarks</th>
						<th>actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($pendingrequests)) : ?>
						<?php foreach ($pendingrequests as $request) : ?>
							<tr>
								<td><?php echo htmlspecialchars($request->user_name); ?></td>
								<td><?php echo htmlspecialchars($request->contact_no); ?></td>
								<td><?php echo htmlspecialchars($request->crop_type); ?></td>
								<td><?php echo htmlspecialchars($request->fertilizer_type); ?></td>
								<td><?php echo htmlspecialchars($request->amount); ?></td>
								<td><?php echo htmlspecialchars($request->preferred_date); ?></td>
								<td><?php echo htmlspecialchars($request->remarks); ?></td>
								<td>
									<button class="green-btn" onclick="confirmApproveRequest(<?php echo $request->id; ?>)">Proceed</button>
									<!-- <button class="red-btn" onclick="confirmRejectRequest(<?php echo $request->id; ?>)">Reject</button> -->

								</td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="8">No fertilizer requests found.</td>
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
						<th>Sitehead <br> Name</th>
						<th>Contact No.</th>
						<th>Crop type</th>
						<th>Requested<br>Fertilizer Type</th>
						<th>Requested<br>Amount(kg)</th>
						<th>Approved<br>Amount(kg)</th>
						<th>Planned <br> Delivery Date</th>
						<!-- <th>actions</th> -->
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($Approvedrequests)) : ?>
						<?php foreach ($Approvedrequests as $request) : ?>
							<tr>
								<td><?php echo htmlspecialchars($request->user_name); ?></td>
								<td><?php echo htmlspecialchars($request->contact_no); ?></td>
								<td><?php echo htmlspecialchars($request->crop_type); ?></td>
								<td><?php echo htmlspecialchars($request->fertilizer_type); ?></td>
								<td><?php echo htmlspecialchars($request->amount); ?></td>
								<td><?php echo htmlspecialchars($request->approvedAmount); ?></td>
								<td><?php echo htmlspecialchars($request->plannedDate); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="7">No handled requests found.</td>
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
						<span class="metric-value"><?php echo number_format($totalStock); ?> kg</span>
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
				<h1>Fertilizer Inventory</h1><br>
			</center>

			<div class="search-bar-container">
				<input type="text" id="fertilizer-search-id" placeholder="Enter Fertilizer Name">
				<button onclick="searchFertilizerByName()" class="search-btn">Search</button>
				<button onclick="clearFertilizerSearch()" class="clear-btn">Clear</button>
			</div>


			<table class="dashboard-table">
				<thead>
					<tr>
						<th>Fertilizer Type</th>
						<th>Current Stock</th>
						<th>Last Restocked</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($fertilizers)) : ?>
						<?php foreach ($fertilizers as $fertilizer) : ?>
							<tr>
								<td><?php echo htmlspecialchars($fertilizer->name); ?></td>
								<td><?php echo htmlspecialchars($fertilizer->amount); ?> kg</td>
								<td><?php echo htmlspecialchars($fertilizer->last_restocked); ?></td>
								<td>
									<button class="blue-btn" onclick="editFertilizerDetails(<?php echo $fertilizer->id; ?>)">Edit Details</button>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="3">No fertilizer stock found.</td>
						</tr>
					<?php endif; ?>
				</tbody>

			</table>
			<p id="no-results-msg" style="display:none; color: red; text-align: center;font-weight:bold;font-size: 21px; margin-top: 8px;">
				No matching fertilizer found.
			</p>


		</div>
	</div>

</body>

</html>