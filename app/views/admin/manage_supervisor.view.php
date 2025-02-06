<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin.css">
    <script src="<?php echo URLROOT; ?>/assets/js/admin.js" defer></script>
    <title>Document</title>
</head>
<body>

<?php
require ROOT . '/views/admin/sidebar.php';
require ROOT . '/views/components/navbar.php';
?>

<!-- <div id="manage-supervisors-section" class="section"> -->
                <center>
                    <h1>Manage Supervisors</h1>
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
                    <button class="green-btn" id="add-supervisor-btn">Add Supervisor</button>
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
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $data): ?>
                    <tr $data-id="<?= htmlspecialchars($data->id) ?>">
                        <td><?= htmlspecialchars($data->name) ?></td>
                        <td><?= htmlspecialchars($data->email) ?></td>
                        <td><?= htmlspecialchars($data->number) ?> </td>
                        <td><?= htmlspecialchars($data->zone) ?></td>
                        <td>
                    <?= $data->status === 0 ? "Active" : "Inactive" ?>
                </td>                    
                        <td>
                            <?php if ($data->status === 0): ?>
                                <button class="green-btn edit-supervisor-btn">Edit</button>    
                                       <?php else: ?>
                                        <button class="green-btn"  onclick="window.location.href='<?php echo URLROOT; ?>/Admin/Manage_supervisor/getid/<?php echo $data->id;?>';">Edit</button>
                                        <button class="red-btn"  onclick="window.location.href='<?php echo URLROOT; ?>/Admin/Manage_supervisor/delete_supervisor/<?php echo $data->id;?>';">Remove</button>

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
                <!-- Add New Supervisor Button -->
                <br>
                

                <!-- Supervisor Details Modal -->
                <div id="supervisor-modal" class="modal">
                    <div class="modal-content">
                        <span class="close-modal">&times;</span>
                        <h2>Supervisor Details</h2>
                        <!-- Supervisor details will be populated dynamically -->
                        <div id="supervisor-details"></div>
                    </div>
                </div>

                <!-- Add Supervisor Form -->
                <div id="add-supervisor-form" class="modal">
                    <div class="modal-content">
                        <span class="close-form">&times;</span>
                        <h2>Add New Supervisor</h2>
                        <form id="new-supervisor-form" form enctype="multipart/form-data" class="form-styles" method="POST" action="<?php echo URLROOT; ?>/Admin/manage_supervisor/add_supervisor">
                            <label for="name">Full Name:</label>
                            <input type="text" id="name" name="name" required>
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                            <label for="number">Phone Number:</label>
                            <input type="number" id="number" name="number" required>
                            <label for="zone">Zone:</label>
                            <select id="zone" name="zone" required>
                                <option value="Zone 1">Zone 1</option>
                                <option value="Zone 2">Zone 2</option>
                                <option value="Zone 3">Zone 3</option>
                                <option value="Zone 4">Zone 4</option>
                            </select>
                            <label for="status">Status:</label>
                            <select id="status" name="status" required>
                                <option value="0">Active</option>
                                <option value="1">Inactive</option>
                            </select>
                            <button type="submit">Add Supervisor</button>
                        </form>
                    </div>
                </div>

                <!-- Edit Supervisor Form -->
                <div id="edit-supervisor-form" class="modal">
                    <div class="modal-content">
                        <span class="close-form">&times;</span>
                        <h2>Edit Supervisor</h2>
                        <form id="edit-supervisor-form" class="form-styles" form enctype="multipart/form-data" method="POST" action="<?php echo URLROOT; ?>/Admin/manage_supervisor/update_supervisor">>
                            <input type="hidden" id="id" name="id" value="<?php $id ?>">
                            <label for="edit-name">Full Name:</label>
                            <input type="text" id="edit-name" name="name" required>
                            <label for="edit-email">Email:</label>
                            <input type="email" id="edit-email" name="email" required>
                            <label for="edit-number">Phone Number:</label>
                            <input type="number" id="edit-number" name="number" required>
                            <label for="edit-zone">Zone:</label>
                            <select id="edit-zone" name="zone" required>
                                <option value="Zone 1">Zone 1</option>
                                <option value="Zone 2">Zone 2</option>
                                <option value="Zone 3">Zone 3</option>
                                <option value="Zone 4">Zone 4</option>
                            </select>
                            <label for="edit-status">Status:</label>
                            <select id="edit-status" name="status" required>
                                <option value="0">Active</option>
                                <option value="1">Inactive</option>
                            </select>
                            <button type="submit">Update Supervisor</button>
                        </form>
                    </div>
                </div>
            
        </div>
</body></html>