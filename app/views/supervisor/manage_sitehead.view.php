<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/supervisor.css" />
  <script src="<?php echo URLROOT; ?>/assets/JS/supervisor.js" defer></script>
  <title>Manage Site Heads</title>
  <style>
  #add-sitehead-btn {
    padding: 8px 16px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-left:1120px;
  }

  #add-sitehead-btn:hover {
    background-color: #3e8e41;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
  }
  
  h1 {
    display: block !important;
    color:green!important;
    text-align: center !important;
    font-size: 32px !important;
    margin-top: 80px !important;
    z-index: 999 !important;
    position: relative !important;
  }
 /* Increase specificity for status colors */
.dashboard-table .active-status {
  color: green;
  font-weight: bold;
}

.dashboard-table .inactive-status {
  color: red;
  font-weight: bold;
}
.no-results-message {
      text-align: center;
      color: gray;
      font-size: 18px;
      margin-top: 20px;
    }


</style>

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

<div class="search-container">
  <input type="text" id="sitehead-search" placeholder="🔍 Search by Name or User ID">
</div>


<table class="dashboard-table">
  <thead>
    <tr>
      <th>User ID</th>
      <th>Name</th>
      <th>Land ID</th>
      <th>Address</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody id="sitehead-list">
    <?php if (!empty($data)): ?>
      <?php foreach ($data as $row): ?>
      <tr 
        data-user_id="<?= $row->user_id ?>"
        data-name="<?= $row->name ?>"
        data-land_id="<?= $row->land_id?>"
        data-address="<?= $row->address?>"
        data-status="<?= $row->status ?>"
      >
        <td><?= $row->user_id ?></td>
        <td><?= $row->name ?></td>
        <td><?= $row->land_id ?></td>
        <td><?= $row->address?></td>
        <td>
  <span class="status-btn <?= $row->status == 0 ? 'active' : 'inactive' ?>">
    <?= $row->status == 0 ? 'Active' : 'Inactive' ?>
  </span>
</td>

      </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="4">No siteheads available.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<div id="no-results-message" class="no-results-message" style="display: none;">
      No results found for your search.
    </div>

  

  <!-- Add Sitehead Modal -->
<div id="add-sitehead-form" class="modal">
  <div class="modal-content">
    <span class="close-form">&times;</span>
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
<script>
document.getElementById("sitehead-search").addEventListener("keyup", function () {
  const filter = this.value.toLowerCase();
  const rows = document.querySelectorAll("#sitehead-list tr");
  let noResults = true;  // Flag to check if no results found

  rows.forEach(row => {
    const userId = row.querySelector("td:nth-child(1)").textContent.toLowerCase();
    const name = row.querySelector("td:nth-child(2)").textContent.toLowerCase();

    if (userId.includes(filter) || name.includes(filter)) {
      row.style.display = "";
      noResults = false;  // Show results if any row matches
    } else {
      row.style.display = "none";
    }
  });

  // Show or hide the "No Results Found" message
  const noResultsMessage = document.getElementById("no-results-message");
  if (noResults) {
    noResultsMessage.style.display = "block";
  } else {
    noResultsMessage.style.display = "none";
  }
});

</script>

</body>

</html>
