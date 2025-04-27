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
			<h1>Manage Buyer</h1>
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
					<th>Buyer ID</th>
					<th>Name</th>
					<th>contact no</th>
					<th>No of bids </th>
					<th></th>

				</tr>
			</thead>
			<tbody id="supervisor-list">
				<?php if (!empty($data)): ?>
					<?php foreach ($data as $buyer): ?>
						<tr data-land-id="<?= htmlspecialchars($buyer->id) ?>">
							<td><?= htmlspecialchars($buyer->id) ?></td>
							<td><?= htmlspecialchars($buyer->full_name) ?></td>
							<td><?= htmlspecialchars($buyer->contact_no) ?></td>
							<!-- <td><?= htmlspecialchars($buyer->kjhk) ?></td> -->
							<td>
								<button class="profile-btn" onclick="window.location.href='<?= URLROOT ?>/Admin/Manage_buyer/getid/<?= $buyer->id ?>';">
									<img src="<?= URLROOT ?>/assets/images/user.png" class="menu-icon">view profile
								</button>
							</td>


						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="7">No buyers available.</td>
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