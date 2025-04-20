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
	<body style="margin-top: 100px; margin-left: 20px; margin-right: 20px;">

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
								<th>Event Name</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody id="supervisor-list">
    <?php if (!empty($history)) : ?>
        <?php foreach ($history as $work): ?>
            <tr>
                <td><?= htmlspecialchars($work->land_location) ?></td>
                <td><?= htmlspecialchars($work->event_name) ?></td>
                <td><?= htmlspecialchars($work->date) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="3">No work history available.</td>
        </tr>
    <?php endif; ?>
</tbody>

					</table>
				</div>
	</body>
</html>