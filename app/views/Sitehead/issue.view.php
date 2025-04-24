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
	<div id="report-issues-section" class="section">
		<div class="complaint-section">
			<div class="form-container">
				<h1 class="complaint-topic">Report an Issue</h1>
				<form class="form" method="POST" action="<?php echo URLROOT; ?>/Sitehead/ReportIssue" enctype="multipart/form-data">

					<div class="form-group">
						<label for="complaint-type">Type of Issue</label>
						<select id="complaint-type" name="complaint-type" required>
							<option value="">Select a category</option>
							<option value="workplace-safety">Workplace Safety Issues</option>
							<option value="salary-delay">Salary Payment Delays</option>
							<option value="unfair-treatment">Unfair Treatment by Management</option>
							<option value="equipment-fault">Faulty Equipment or Tools</option>
							<option value="long-hours">Excessive Working Hours</option>
							<option value="leave-requests">Denied or Delayed Leave Requests</option>
							<option value="training-issues">Inadequate Training Provided</option>
							<option value="workload">Excessive Workload</option>
							<option value="Communication">Poor Communication from Supervisors</option>
							<option value="other">Other</option>
						</select>
						<label for="description">Issue Description</label>
						<textarea id="description" name="description" required
							placeholder="Please provide detailed information about your complaint..."></textarea>
						<label for="attachment">Supporting Documents (if any)</label>
						<input type="file" id="attachment" name="attachment">
						<p class="attachment-note">Accepted file formats: PDF, JPG, PNG (Max size: 5MB)</p>
						<button class="form-submit-btn" type="submit">
							<i class="fas fa-paper-plane"></i>&nbsp; Submit Issue
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

</html>