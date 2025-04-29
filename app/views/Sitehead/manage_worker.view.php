<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/sitehead.css">
	<title>Manage Workers</title>
	<style>
		.event-container {
			display: flex;
			flex-direction: column;
			gap: 8px;
		}

		.event-item {
			display: flex;
			align-items: center;
			gap: 10px;
			padding: 8px;
			border-radius: 4px;
			background-color: #f5f5f5;
		}

		.event-badge {
			border-radius: 12px;
			padding: 4px 10px;
			font-size: 12px;
			flex-grow: 1;
		}

		.event-badge.pending {
			background-color: #fff3cd;
			color: #856404;
		}

		.event-badge.approved {
			background-color: #d4edda;
			color: #155724;
		}

		.event-badge.rejected {
			background-color: #f8d7da;
			color: #721c24;
		}

		.approve-btn {
			background-color: #28a745;
			color: white;
			border: none;
			padding: 4px 8px;
			border-radius: 4px;
			cursor: pointer;
			text-decoration: none;
			font-size: 12px;
		}

		.approve-btn:hover {
			background-color: #218838;
		}
	</style>
</head>

<body>
	<?php
	require ROOT . '/views/sitehead/sidebar.php';
	require ROOT . '/views/components/topbar.php';
	?>
	<div id="manage-workers-section" class="section">
		<center>
			<h1>Manage Workers</h1>
		</center>
		<br><br>
		<!-- Search and Filter Section -->
		<div class="filter-section">
			<input type="text" id="search-bar" placeholder="Search workers by name or email">
			<select id="status-filter">
				<option value="">All Status</option>
				<option value="active">Active</option>
				<option value="inactive">Inactive</option>
			</select>
		</div>
		<!-- Workers Table -->
		<table class="dashboard-table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Phone Number</th>
					<th>Status</th>
					<th>Applied Events</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody id="worker-list">
				<?php foreach ($workers as $worker): ?>
					<tr data-id="<?= $worker['id'] ?>">
						<td><?= htmlspecialchars($worker['name']) ?></td>
						<td><?= htmlspecialchars($worker['email']) ?></td>
						<td><?= htmlspecialchars($worker['phone']) ?></td>
						<td><?= htmlspecialchars($worker['status']) ?></td>
						<td>
							<div class="event-container">
								<?php foreach ($worker['applied_events'] as $event): ?>
									<div class="event-badge <?= $event['status'] ?>">
										<?= htmlspecialchars($event['event_name']) ?>
										(<?= date('M j, Y', strtotime($event['date'])) ?>)
									</div>
								<?php endforeach; ?>
								<?php if (empty($worker['applied_events'])): ?>
									<div class="event-badge">No events applied</div>
								<?php endif; ?>
							</div>
						</td>
						<td>
							<div class="event-container">
								<?php foreach ($worker['applied_events'] as $event): ?>
									<?php if ($event['status'] == 'Pending'): ?>
										<div class="event-item">
											<a href="<?= URLROOT ?>/manage_worker/approve_event/<?= $worker['id'] ?>/<?= $event['event_id'] ?>"
												class="approve-btn"
												onclick="return confirm('Approve this worker for <?= htmlspecialchars($event['event_name']) ?>?')">
												Approve
											</a>
										</div>
									<?php else: ?>
										<div class="event-item">
											<span class="event-badge <?= $event['status'] ?>">
												<?= ucfirst($event['status']) ?>
											</span>
										</div>
									<?php endif; ?>
								<?php endforeach; ?>
								<?php if (empty($worker['applied_events'])): ?>
									<div class="event-item">-</div>
								<?php endif; ?>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<script>
		// Search functionality
		document.getElementById('search-bar').addEventListener('input', function() {
			const searchTerm = this.value.toLowerCase();
			const rows = document.querySelectorAll('#worker-list tr');

			rows.forEach(row => {
				const name = row.cells[0].textContent.toLowerCase();
				const email = row.cells[1].textContent.toLowerCase();
				if (name.includes(searchTerm) || email.includes(searchTerm)) {
					row.style.display = '';
				} else {
					row.style.display = 'none';
				}
			});
		});

		// Status filter functionality
		document.getElementById('status-filter').addEventListener('change', function() {
			const status = this.value.toLowerCase();
			const rows = document.querySelectorAll('#worker-list tr');

			rows.forEach(row => {
				const rowStatus = row.cells[3].textContent.toLowerCase();
				if (!status || rowStatus.includes(status)) {
					row.style.display = '';
				} else {
					row.style.display = 'none';
				}
			});
		});
	</script>
</body>

</html>