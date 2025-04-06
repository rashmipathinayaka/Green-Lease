<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/landowner/manageland.css">

	<title>Manage Lands</title>


</head>

<body>
	<?php
	require ROOT . '/views/landowner/sidebar.php';
	require ROOT . '/views/components/navbar.php';
	?>

	<div id="manage-lands-section">

		<h2>Please Note That You Can Only Remove Unused Lands</h2>
		<br>
		<!-- Lands Table -->
		<table class="dashboard-table">
			<thead>
				<tr>
					<th>Land ID</th>
					<th>Address</th>
					<th>Size</th>
					<th>Crop Type</th>
					<th>Document</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody id="supervisor-list">
				<?php if (!empty($lands)): ?>
					<?php foreach ($lands as $land): ?>
						<tr data-land-id="<?= htmlspecialchars($land->id) ?>">
							<td><?= htmlspecialchars($land->id) ?></td>
							<td><?= htmlspecialchars($land->address) ?></td>
							<td><?= htmlspecialchars($land->size) ?> Sqm</td>
							<td><?= htmlspecialchars($land->crop) ?></td>
							<td>
								<?php if (!empty($land->document)): ?>
									<a href="<?php echo URLROOT . '/' .  $land->document; ?>" target="_blank">
										View Document
									</a>

								<?php else: ?>
									No Attachment
								<?php endif; ?>
							</td>
							<td>
							<?= htmlspecialchars($land->status) ?>
							</td>
							<td>
								<?php if ($land->status === 'inactive'): ?>
									<button class="red-btn" onclick="openModal('<?= URLROOT ?>/Landowner/Manageland/deleteland/<?php echo $land->id; ?>')">Remove</button>
								<?php elseif($land->status === 'active' || $land->status === 'completed'): ?>
									<button class="green-btn">View project</button>
									<?php else:?>
										<span class="status-pending">Pending for approval</span>
										<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="7">No lands available.</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>

		<!-- Custom Delete Confirmation Modal -->
		<div id="deleteModal" class="modal">
			<div class="modal-content">
				<p>Are you sure you want to delete this land?</p>
				<button id="confirmDelete" class="confirm-btn">Yes, Delete</button>
				<button onclick="closeModal()" class="cancel-btn">Cancel</button>
			</div>
		</div>

	</div>

	<script>
		let deleteUrl = "";

		function openModal(url) {
			deleteUrl = url; // Store the delete link
			document.getElementById("deleteModal").style.display = "flex";
		}

		function closeModal() {
			document.getElementById("deleteModal").style.display = "none";
		}

		// Confirm deletion
		document.getElementById("confirmDelete").addEventListener("click", function() {
			window.location.href = deleteUrl;
		});

		// Close modal if clicked outside of the content
		window.onclick = function(event) {
			let modal = document.getElementById("deleteModal");
			if (event.target === modal) {
				closeModal();
			}
		};
	</script>

</body>

</html>