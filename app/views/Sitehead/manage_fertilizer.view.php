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
	require ROOT . '/views/components/navbar.php';
	?>
	<div id="request-fertilizers-section" class="section">
		<div class="complaint-section">
			<div class="form-container">
				<h1 class="complaint-topic">Request for Fertilizers</h1>
				<form class="form" method="POST" action="<?php echo URLROOT; ?>/Sitehead/Manage_fertilizer">

					<div class="form-group">
						<label for="sitehead_id">Sitehead ID</label>
						<input type="text" id="sitehead_id" name="sitehead_id" required>
						<label for="project_id">Project ID</label>
						<input type="text" id="project_id" name="project_id" required>
						<label for="type">Fertilizer Type</label>
						<select id="type" name="type" required>
							<option value="">Select Fertilizer Type</option>
							<option value="urea">Urea</option>
							<option value="dap">DAP</option>
							<option value="npk">NPK</option>
							<option value="tsp">Triple Super Phosphate(TSP)</option>
							<option value="AS">Ammonium Sulphate</option>
							<option value="compost">Compost</option>
							<option value="nitrogen">Nitrogen</option>
							<option value="dolomite">Dolomite</option>
							<option value="cowdung">Dried Cow Dung Manure</option>
							<option value="goatdung">Dried Goat Dung Manure</option>
							<option value="other">Other</option>
						</select>
						<label for="amount">Amount (in kg)</label>
						<input type="number" id="amount" name="amount" step="0.01" min="0" required>

						<label for="remarks">Special Requirements/Notes</label>
						<textarea id="remarks" name="remarks"
							placeholder="Special Requirements (If any)"></textarea>
						<label for="preferred_date">Preferred Delivery Date</label>
						<input type="date" id="preferred_date" name="preferred_date" required>
						<button class="form-submit-btn" type="submit">
							<i class="fas fa-paper-plane"></i>&nbsp; Submit Request
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

</html>