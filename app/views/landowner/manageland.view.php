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
	require ROOT . '/views/components/topbar.php';
	?>

	<div id="manage-lands-section">
		<div class="note-container">
			<div class="note">
				<i class="fas fa-info-circle"></i>
				<p>Please Note That You Can Only Remove Unused Lands</p>
			</div>
		</div>
		<br>
		<!-- Lands Table -->
		<table class="dashboard-table">
			<thead>
				<tr>
					<th>Land ID</th>
					<th>Address</th>
					<th>Size</th>
					<th>Preffered crop Type</th>
					<!-- <th>Seleted crop type</th> -->
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
							<td><?= htmlspecialchars($land->crop_type) ?></td>
							<!-- <td><?= htmlspecialchars($land->selected_crop_type) ?></td> -->


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
								<?php
								if ($land->status == '3') {
									echo 'Completed';
								} elseif ($land->status == '1') {
									echo 'Pending';
								} elseif ($land->status == '2') {
									echo 'Ongoing Project';
								} else {
									echo 'Unused';
								}
								?>
							</td>

							<td>
								<?php if ($land->status == '4'): ?>
									<button class="red-btn" onclick="openModal('<?= URLROOT ?>/Landowner/Manageland/deleteland/<?php echo $land->id; ?>')">Remove</button>
								<?php elseif ($land->status == '2' || $land->status == '3'): ?>
									<button class="green-btn" onclick="window.location.href='<?= URLROOT ?>/project/index/<?= $land->proid ?>';">View project</button>
									<?php else: ?>
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

	<style>
		.note-container {
			margin: 20px 0;
			padding: 0 20px;
		}

		.note {
			background-color: #fff3e0;
			border-left: 4px solid #ff9800;
			padding: 15px 20px;
			border-radius: 4px;
			display: flex;
			align-items: center;
			gap: 12px;
			max-width: 800px;
			margin: 0 auto;
		}

		.note i {
			color: #ff9800;
			font-size: 22px;
			flex-shrink: 0;
		}

		.note p {
			margin: 0;
			color: #e65100;
			font-size: 16px;
			line-height: 1.5;
			font-weight: 500;
		}

		@media (max-width: 768px) {
			.note-container {
				padding: 0 15px;
			}

			.note {
				padding: 12px 15px;
			}
		}
	</style>

</body>

</html>