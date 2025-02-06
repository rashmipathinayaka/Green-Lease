<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin.css">

    <title>Document</title>
</head>
<body>

<?php

require ROOT . '/views/admin/sidebar.php';
require ROOT . '/views/components/navbar.php';

?>

<div id="manage-workers-section" class="section">
					<center>
                        <h1>Manage Workers</h1>
                    </center>
					<br><br>
					<!-- Search and Filter Section -->
					<div class="filter-section">
						<input type="text" id="search-bar" placeholder="Search supervisors by name or email">
						<select id="status-filter">
							<option value="">All Status</option>
							<option value="active">Active</option>
							<option value="inactive">Inactive</option>
						</select>
						<select id="zone-filter">
							<option value="">Zone</option>
							<option value="Zone 1">Zone 1</option>
							<option value="Zone 2">Zone 2</option>
						</select>
						<button class="green-btn" id="add-supervisor-btn">Add Worker</button>
					</div>
					<!-- Supervisors Table -->
					<table class="dashboard-table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Phone Number</th>
								<th>Zone</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody id="supervisor-list">
							<tr data-id="1">
								<td>Yasitha Vas</td>
								<td>yvas@gmail.com</td>
								<td>0715559997</td>
								<td>Zone 1</td>
								<td>Active</td>
								<td>
									<button class="green-btn edit-btn" data-id="1">Edit</button>
									<button class="red-btn">Deactivate</button>
								</td>
							</tr>
							<tr data-id="2">
								<td>Samantha Perera</td>
								<td>samantha@gmail.com</td>
								<td>0715551234</td>
								<td>Zone 2</td>
								<td>Inactive</td>
								<td>
									<button class="green-btn edit-btn" data-id="2">Edit</button>
									<button class="red-btn">Deactivate</button>
								</td>
							</tr>
							<tr data-id="3">
								<td>Prabath Jayasinghe</td>
								<td>prabathjaya@gmail.com</td>
								<td>0776543210</td>
								<td>Zone 3</td>
								<td>Active</td>
								<td>
									<button class="green-btn edit-btn" data-id="3">Edit</button>
									<button class="red-btn">Deactivate</button>
								</td>
							</tr>
							<tr data-id="4">
								<td>Anushka Fernando</td>
								<td>anushka.fernando@gmail.com</td>
								<td>0789004567</td>
								<td>Zone 4</td>
								<td>Active</td>
								<td>
									<button class="green-btn edit-btn" data-id="4">Edit</button>
									<button class="red-btn">Deactivate</button>
								</td>
							</tr>
							<tr data-id="5">
								<td>Kamini Mapa</td>
								<td>kamini.mapa@gmail.com</td>
								<td>0712233445</td>
								<td>Zone 5</td>
								<td>Inactive</td>
								<td>
									<button class="green-btn edit-btn" data-id="5">Edit</button>
									<button class="red-btn">Deactivate</button>
								</td>
							</tr>
						</tbody>
					</table>
					<!-- Add New Supervisor Button -->
					<br>
					<!-- Supervisor Details Modal -->
					<div id="supervisor-modal" class="modal">
						<div class="modal-content">
							<span class="close-modal">&times;</span>
							<h2>Worker Details</h2>
							<!-- Supervisor details will be populated dynamically -->
							<div id="supervisor-details"></div>
						</div>
					</div>
					<!-- Add Supervisor Form -->
					<div id="add-supervisor-form" class="modal">
						<div class="modal-content">
							<span class="close-form">&times;</span>
							<h2>Add New Worker</h2>
							<form id="new-supervisor-form" class="form-styles">
								<label for="name">Full Name:</label>
								<input type="text" id="name" name="name" required>
								<label for="email">Email:</label>
								<input type="email" id="email" name="email" required>
								<label for="phone">Phone Number:</label>
								<input type="tel" id="phone" name="phone" required>
								<label for="zone">Zone:</label>
								<select id="zone" name="zone" required>
									<option value="Zone 1">Zone 1</option>
									<option value="Zone 2">Zone 2</option>
									<option value="Zone 3">Zone 3</option>
									<option value="Zone 4">Zone 4</option>
								</select>
								<label for="status">Status:</label>
								<select id="status" name="status" required>
									<option value="Active">Active</option>
									<option value="Inactive">Inactive</option>
								</select>
								<button type="submit">Add Worker</button>
							</form>
						</div>
					</div>
					<!-- Edit Supervisor Form -->
					<div id="edit-supervisor-form" class="modal">
						<div class="modal-content">
							<span class="close-form">&times;</span>
							<h2>Edit Worker</h2>
							<form id="edit-supervisor-form" class="form-styles">
								<input type="hidden" id="edit-supervisor-id">
								<label for="edit-name">Full Name:</label>
								<input type="text" id="edit-name" name="name" required>
								<label for="edit-email">Email:</label>
								<input type="email" id="edit-email" name="email" required>
								<label for="edit-phone">Phone Number:</label>
								<input type="tel" id="edit-phone" name="phone" required>
								<label for="edit-zone">Zone:</label>
								<select id="edit-zone" name="zone" required>
									<option value="Zone 1">Zone 1</option>
									<option value="Zone 2">Zone 2</option>
									<option value="Zone 3">Zone 3</option>
									<option value="Zone 4">Zone 4</option>
								</select>
								<label for="edit-status">Status:</label>
								<select id="edit-status" name="status" required>
									<option value="Active">Active</option>
									<option value="Inactive">Inactive</option>
								</select>
								<button type="submit">Update Worker</button>
							</form>
						</div>
					</div>
				</div>

                <div id="manage-lands-section" class="section" style="display:none;">
             <h1>Section 4 Content</h1>
              <!-- Add content for Section 4 -->
        </div>
</body>
</html>