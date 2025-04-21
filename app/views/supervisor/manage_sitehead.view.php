<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/supervisor.css" />
  <script src="<?php echo URLROOT; ?>/assets/JS/supervisor.js" defer></script>
  <title>Manage Site Heads</title>
  

</head>

<body>
<?php
require ROOT . '/views/supervisor/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>
<div id="manage-site-heads-section" class="section">
  <center>
    <h1>Manage Site Heads</h1>
  </center>
  <br><br>
  

  <button class="green-btn" id="add-sitehead-btn">
  &#43; Add Site Head
</button>

  
<table class="dashboard-table">
  <thead>
    <tr>
      <th>Project ID</th>
      <th>User ID</th>
      <th>Land ID</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody id="sitehead-list">
    <?php if (!empty($data)): ?>
      <?php foreach ($data as $row): ?>
      <tr 
        data-id="<?= $row->id ?>"
        data-land_id="<?= $row->land_id?>"
        data-user_id="<?= $row->user_id ?>"
        data-status="<?= $row->status ?>"
      >
        <td><?= $row->id ?></td>
        <td><?= $row->user_id ?></td>
        <td><?= $row->land_id ?></td>
        <td><?= $row->status == 0 ? 'Active' : 'Inactive' ?></td>
      </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="4">No siteheads available.</td></tr>
    <?php endif; ?>
  </tbody>
</table>


  

  <!-- Add Sitehead Modal -->
<div id="add-sitehead-form" class="modal">
  <div class="modal-content">
  <span class="close" onclick="closeModal()">&times;</span>
    <h2>Add New Site Head</h2>
    <form method="POST" action="<?php echo URLROOT; ?>/Supervisor/manage_sitehead/add_sitehead" class="form-styles">
      <label>User ID:</label>
      <input type="number" name="user_id" required>
      <label>Land ID:</label>
      <input type="number" name="land_id" required>
      <label>Status:</label>
      <select name="status">
        <option value="0">Active</option>
        <option value="1">Inactive</option>
      </select>
      <button type="submit">Add</button>
    </form>
  </div>
</div>

<!-- Edit Sitehead Modal -->
<div id="edit-sitehead-form" class="modal">
  <div class="modal-content">
    <span class="close-form">&times;</span>
    <h2>Edit Site Head</h2>
    <form method="POST" action="<?php echo URLROOT; ?>/Supervisor/manage_sitehead/update_sitehead" class="form-styles">
      <input type="hidden" name="id" id="edit-id">
      <label>User ID:</label>
      <input type="number" name="user_id" id="edit-user_id" required>
      <label>Land ID:</label>
      <input type="number" name="land_id" id="edit-land_id" required>
      <label>Status:</label>
      <select name="status" id="edit-status">
        <option value="0">Active</option>
        <option value="1">Inactive</option>
      </select>
      <button type="submit">Update</button>
    </form>
  </div>
</div>

</div>
</body>

</html>
