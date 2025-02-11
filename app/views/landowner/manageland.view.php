<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/landowner.css">

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
				<!-- lands Table -->
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
								<tr $land-id="<?= htmlspecialchars($land->id) ?>">
									<td><?= htmlspecialchars($land->id) ?></td>
									<td><?= htmlspecialchars($land->address) ?></td>
									<td><?= htmlspecialchars($land->size) ?> Sqm</td>
									<td><?= htmlspecialchars($land->crop) ?></td>
									<td>
										<?php if (!empty($land->document)): ?>
											<a href="<?php echo ROOT . '/../app' . $land->document; ?>" target="_blank"
												style="text-decoration: none; color:white;" class="blue-btn">View</a>
										<?php else: ?>
											No Attachment
										<?php endif; ?>
									</td>
									<td>
										<?= $land->status === 1 ? "Active" : "Inactive" ?>
									</td>
									<td>
										<?php if ($land->status === 0): ?>
											<button class="red-btn"
												onclick="window.location.href='<?= ROOT ?>/Landowner/deleteland/<?php echo $land->id; ?>';">Remove</button>
										<?php else: ?>
											<button class="green-btn">View</button>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="5">No lands available.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
</body>
</html>