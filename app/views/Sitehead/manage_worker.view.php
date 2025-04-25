<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/sitehead.css">
	<title>Manage Workers</title>
	<style>
		.event-badge {
			background-color: #e0e0e0;
			border-radius: 12px;
			padding: 2px 8px;
			margin: 2px;
			display: inline-block;
			font-size: 12px;
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
							<?php foreach ($worker['applied_events'] as $event): ?>
								<div class="event-badge <?= $event['status'] ?>">
									<?= htmlspecialchars($event['event_name']) ?>
									(<?= date('M j, Y', strtotime($event['date'])) ?>)
									<?php if ($event['status'] == 'pending'): ?>
										<a href="<?= URLROOT ?>/manage_worker/approve_event/<?= $worker['id'] ?>/<?= $event['event_id'] ?>"
											class="approve-btn"
											onclick="return confirm('Approve this worker for <?= htmlspecialchars($event['event_name']) ?>?')">
											Approve
										</a>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
							<?php if (empty($worker['applied_events'])): ?>
								No events applied
							<?php endif; ?>
						</td>
						<td>
							<button class="green-btn edit-btn" data-id="<?= $worker['id'] ?>">Edit</button>
							<?php if ($worker['status'] == 'Active'): ?>
								<button class="red-btn deactivate-btn" data-id="<?= $worker['id'] ?>">Deactivate</button>
							<?php else: ?>
								<button class="blue-btn activate-btn" data-id="<?= $worker['id'] ?>">Activate</button>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<!-- Edit Worker Form -->
	<div id="edit-worker-form" class="modal">
		<div class="modal-content">
			<span class="close-form">&times;</span>
			<h2>Edit Worker</h2>
			<form id="edit-worker-form" class="form-styles">
				<input type="hidden" id="edit-worker-id">
				<label for="edit-name">Full Name:</label>
				<input type="text" id="edit-name" name="name" required>
				<label for="edit-email">Email:</label>
				<input type="email" id="edit-email" name="email" required>
				<label for="edit-phone">Phone Number:</label>
				<input type="tel" id="edit-phone" name="phone" required>
				<label for="edit-status">Status:</label>
				<select id="edit-status" name="status" required>
					<option value="Active">Active</option>
					<option value="Inactive">Inactive</option>
				</select>
				<button type="submit">Update Worker</button>
			</form>
		</div>
	</div>

	<script>
		// Add your JavaScript for handling modals, search, etc. here
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