<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/sitehead.css">
	<title>Document</title>
</head>

<body >
	<?php
	require ROOT . '/views/sitehead/sidebar.php';
	require ROOT . '/views/components/topbar.php';
	?>
	<div id="request-fertilizers-section" class="section">
		<div class="complaint-section">
			<div class="form-container">
				<h1 class="complaint-topic">Request for Fertilizers</h1>
				<form class="form" method="POST" action="<?php echo URLROOT; ?>/Sitehead/Manage_fertilizer">

					<div class="form-group">

						<!-- <label for="project_id">Select Project</label>
						<select id="project_id" name="project_id" required>
							<option value="">Select a Project</option>
							<?php foreach ($projects as $project): ?>
								<option value="<?= htmlspecialchars($project->id) ?>">
									Project #<?= htmlspecialchars($project->id) ?> -
									<?= htmlspecialchars($project->crop_type) ?> (Land: <?= htmlspecialchars($project->land_id) ?>)
								</option>
							<?php endforeach; ?>
						</select> -->

						<label for="fertilizer_id">Fertilizer Type</label>
						<select id="fertilizer_id" name="fertilizer_id" required>
							<?php foreach ($fertilizers as $fertilizer): ?>
								<option value="<?= htmlspecialchars($fertilizer->id) ?>">
									<?= htmlspecialchars($fertilizer->name) ?>
								</option>
							<?php endforeach; ?>
							<option value="other">Other (Please Specify in Notes)</option>
						</select>

						<label for="amount">Amount (in kg)</label>
						<input type="number" id="amount" name="amount" step="0.01" min="0" required>

						<label for="remarks">Special Requirements/Notes</label>
						<textarea id="remarks" name="remarks"
							placeholder="Special Requirements (If any)"></textarea>

						<label for="preferred_date">Preferred Delivery Date</label>
						<input type="date" id="preferred_date" name="preferred_date" min="<?php echo date('Y-m-d'); ?>" required>

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