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

<body>
	<?php
	require ROOT . '/views/supervisor/sidebar.php';
	require ROOT . '/views/components/navbar.php';
	?>
	<div id="manage-issues-section">
		<!-- Tab Navigation -->
		<div class="tab-navigation">
			<button class="tab-btn active" onclick="switchTabs(this, 'pending-issues')">Pending Issues</button>
			<button class="tab-btn" id="solved-issues-btn" onclick="switchTabs(this, 'solved-issues')">Solved Issues</button>
		</div>
		<!-- Handle Request Tab -->
		<div id="pending-issues" class="tab-content active">
			<!-- <h2> Requests</h2> -->
			<table class="dashboard-table">
				<thead>
					<tr>
						<th>Sitehead Name</th>
						<th>Contact No.</th>
						<th>Complaint Type</th>
						<th>Description</th>
						<th>Attachment</th>
						<th>Actions</th>
					</tr>
				</thead>

				<tbody>
					<?php if (!empty($pendingIssues)) : ?>
						<?php foreach ($pendingIssues as $issue) : ?>
							<tr>
								<td><?php echo htmlspecialchars($issue->user_name ?? 'Unknown'); ?></td>
								<td><?php echo htmlspecialchars($issue->contact_no ?? 'N/A'); ?></td>
								<td><?php echo htmlspecialchars($issue->complaint_type); ?></td>
								<td><?php echo htmlspecialchars($issue->description); ?></td>
								<td>
									<?php if (!empty($issue->attachment)) : ?>
										<a href="<?php echo URLROOT . '/../app/uploads/issues/' . $issue->attachment; ?>" target="_blank">View</a>
									<?php else : ?>
										No Attachment
									<?php endif; ?>
								</td>
								<td>

									<button class="green-btn" onclick="confirmMarkAsSolved(<?php echo $issue->id; ?>)">Mark as Solved</button>
									<!-- <button class="red-btn" onclick="confirmRemoveIssue(<?php echo $issue->id; ?>)">Remove</button> -->
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="5">No pending issues found.</td>
						</tr>
					<?php endif; ?>
				</tbody>

			</table>
		</div>
		<div id="solved-issues" class="tab-content" style="display:none;">
			<!-- <h2> Requests</h2> -->
			<table class="dashboard-table">
				<thead>
					<tr>
						<th>Sitehead Name</th>
						<th>Contact No.</th>
						<th>Complaint Type</th>
						<th>Description</th>
						<th>Attachment</th>

					</tr>
				</thead>

				<tbody>
					<?php if (!empty($solvedIssues)) : ?>
						<?php foreach ($solvedIssues as $issue) : ?>
							<tr>
								<td><?php echo htmlspecialchars($issue->user_name ?? 'Unknown'); ?></td>
								<td><?php echo htmlspecialchars($issue->contact_no ?? 'N/A'); ?></td>
								<td><?php echo htmlspecialchars($issue->complaint_type); ?></td>
								<td><?php echo htmlspecialchars($issue->description); ?></td>
								<td>
									<?php if (!empty($issue->attachment)) : ?>
										<a href="<?php echo URLROOT . '/../app/uploads/issues/' . $issue->attachment; ?>" target="_blank">View</a>
									<?php else : ?>
										No Attachment
									<?php endif; ?>
								</td>
								<!-- <td>
									<button class="red-btn" onclick="window.location.href='<?php echo URLROOT; ?>/Supervisor/ManageIssues/deleteIssue/<?php echo $issue->id; ?>'">Delete</button>
								</td> -->
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="5">No solved issues found.</td>
						</tr>
					<?php endif; ?>
				</tbody>

			</table>
		</div>
	</div>
</body>

</html>