<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/supervisor.css">
    <script src="<?php echo URLROOT; ?>/assets/js/supervisor.js" defer></script>

    <title>Document</title>
</head>
<body>
<?php
require ROOT . '/views/supervisor/sidebar.php';
require ROOT . '/views/components/navbar.php';
?>
<div id="manage-site-heads-section" >
					<center>
						<h1>Manage Site Heads</h1>
					</center>
					<br><br>
					<!-- Search and Filter Section -->
					
						<button class="green-btn" id="add-sitehead-btn">Add Site Head</button>
					
					<!-- siteheads Table -->
					<table class="dashboard-table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Phone Number</th>
								<th>landID</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody id="sitehead-list">

                          <?php if (!empty($data)): ?>

                              <?php foreach ($data as $data): ?>

                        <tr data-id="<?= htmlspecialchars($data->id) ?>">

                        <td><?= htmlspecialchars($data->name) ?></td>

                        <td><?= htmlspecialchars($data->email) ?></td>

                        <td><?= htmlspecialchars($data->number) ?> </td>

                        <td><?= htmlspecialchars($data->landID) ?></td>

                        <td>

                      <?= $data->status === 0 ? "Active" : "Inactive" ?>

                         </td>                    

                        <td>

                            <?php if ($data->status === 0): ?>

                                <button class="green-btn edit-sitehead-btn" >Edit</button>   

                                       <?php else: ?>

                                        <button class="green-btn edit-sitehead-btn">Edit</button>   

                                        <button class="red-btn"  onclick="window.location.href='<?php echo URLROOT; ?>/Supervisor/Manage_sitehead/delete_sitehead/<?php echo $data->id;?>';">Remove</button>



                                                 <?php endif; ?>

                                   </td>

                               </tr>

                           <?php endforeach; ?>

                                 <?php else: ?>

                           <tr>

                           <td colspan="5">No siteheads available.</td>

                             </tr>

                            <?php endif; ?>

                 </tbody>
					</table>
					<!-- Add New sitehead Button -->
					<br>
					<!-- sitehead Details Modal -->
					<!-- <div id="sitehead-modal" class="modal">
						<div class="modal-content">
							<span class="close-modal">&times;</span>
							<h2>Site Head Details</h2>
							 sitehead details will be populated dynamically -->
							<!-- <div id="sitehead-details"></div>
						</div>
					</div> --> 
					<!-- Add sitehead Form -->
					<div id="add-sitehead-form" class="modal">
						<div class="modal-content">
							<span class="close-form">&times;</span>
							<h2>Add New Site Head</h2>
							<form id="new-sitehead-form" class="form-styles" method="POST" action="<?php echo URLROOT; ?>/Supervisor/manage_sitehead/add_sitehead">					
								<label for="name">Full Name:</label>
								<input type="text" id="name" name="name" required>
								<label for="email">Email:</label>
								<input type="email" id="email" name="email" required>
								<label for="number">Phone Number:</label>
								<input type="number" id="number" name="number" required>
								<label for="landID">landID:</label>
								<input type="number" id="landID" name="landID" required>
								<label for="status">Status:</label>
								<select id="status" name="status" required>
									<option value="0">Active</option>
									<option value="1">Inactive</option>
								</select>
								<button type="submit">Add Site Head</button>
							</form>
						</div>
					</div>
					<!-- Edit sitehead Form -->
					<div id="edit-sitehead-form" class="modal">
						<div class="modal-content">
							<span class="close-form">&times;</span>
							<h2>Edit Site Head</h2>
							<form id="edit-sitehead-form" class="form-styles" method="POST" action="<?php echo URLROOT; ?>/Supervisor/manage_sitehead/update_sitehead">>		
								
								<input type="number" id="edit-id" name="id" hidden>
								<label for="edit-name">Full Name:</label>
								<input type="text" id="edit-name" name="name" required>
								<label for="edit-email">Email:</label>
								<input type="email" id="edit-email" name="email" required>
								<label for="edit-number">Phone Number:</label>
								<input type="number" id="edit-number" name="number" required>
								<label for="edit-landID">landID:</label>
								<input type="number" id="edit-landID" name="landID" required>

								<label for="edit-status">Status:</label>
								<select id="edit-status" name="status" required>
									<option value="0">Active</option>
									<option value="1">Inactive</option>
								</select>
								<button type="submit">Update Site Head</button>
							</form>
						</div>
					</div>
				</div>
</body>
</html>