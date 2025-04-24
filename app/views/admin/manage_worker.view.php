<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin/manage-supervisor.css">

	<title>Document</title>
</head>

<body>

	<?php

	require ROOT . '/views/admin/sidebar.php';
	require ROOT . '/views/components/topbar.php';

	?>

	<div class="content">
		<center>
			<h1>Manage Workers</h1>
		</center>

		<br><br>
		<!-- Search and Filter Section -->
		<div class="filter-section">
			<form method="GET" action="" class="filter-form" style="margin-bottom: 20px; text-align: center;">
				<label for="name">Name:</label>
				<input type="text" name="full_name" id="full_name" value="<?= isset($_GET['full_name']) ? htmlspecialchars($_GET['full_name']) : '' ?>">

				<button type="submit">Filter</button>
			</form>
		</div>


	<!-- Supervisors Table -->



		<br>
		<!-- Lands Table -->
		<table class="dashboard-table">
			<thead>
				<tr>
					<th>Worker ID</th>
					<th>Name</th>
					<th>contact no</th>
					<th>No of events joined</th>
					<th></th>

				</tr>
			</thead>
			<tbody id="supervisor-list">
				<?php if (!empty($data)): ?>
					<?php foreach ($data as $worker): ?>
						<tr data-land-id="<?= htmlspecialchars($worker->id) ?>">
							<td><?= htmlspecialchars($worker->id) ?></td>
							<td><?= htmlspecialchars($worker->full_name) ?></td>
							<td><?= htmlspecialchars($worker->contact_no) ?></td>
							<td><?= htmlspecialchars($worker->no_events) ?></td>
							<td>
								<button class="profile-btn" onclick="window.location.href='<?= URLROOT ?>/Admin/Manage_worker/getid/<?= $worker->id ?>';">
									<img src="<?= URLROOT ?>/assets/images/user.png" class="menu-icon">view profile
								</button>
							</td>


						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="7">No workers available.</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>

		<div id="manage-lands-section" class="section" style="display:none;">
			<h1>Section 4 Content</h1>
			<!-- Add content for Section 4 -->
		</div></div>
</body>

</html>