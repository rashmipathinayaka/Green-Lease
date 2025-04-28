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
    padding: 8px 10px;
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
    margin-left:1110px;
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
  color: darkgreen;
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
  <?php if (!empty($success)): ?>
    <div style="padding: 10px; background-color: #d4edda; color: #155724; margin-bottom: 10px; border: 1px solid #c3e6cb; border-radius: 5px;">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>
<!-- Error message display -->
<?php if (isset($error)): ?>
        <div class="error-message" style="padding: 10px; background-color: #f8d7da; color: #721c24; margin-bottom: 10px; border: 1px solid #f5c6cb; border-radius: 5px;">
            <?= $error ?>
        </div>
    <?php endif; ?>


  <button class="green-btn" id="add-sitehead-btn">
  &#43; Assign Site Head
</button>

<div class="search-container">
  <input type="text" id="sitehead-search" placeholder="🔍 Search by Name or User ID">
</div>


<table class="dashboard-table">
  <thead>
    <tr>
      <th>User ID</th>
      <th>Name</th>
      <th>Contact Number</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody id="sitehead-list">
    <?php if (!empty($data)): ?>
      <?php foreach ($data as $row): ?>
      <tr 
        data-id="<?= $row->id ?>"
        data-name="<?= $row->full_name ?>"
        data-contact_no="<?= $row->contact_no?>"
         data-status="<?= $row->status?>"
       
      >
        <td><?= $row->id ?></td>
        <td><?= $row->full_name ?></td>
        <td><?= $row->contact_no?></td>
        <td class="<?= $row->status == 'Active' ? 'active-status' : 'inactive-status' ?>">
  <?= $row->status == 'Active' ? 'Active' : 'Inactive' ?>
</td>

        

      </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="4">No siteheads available.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<div id="no-results-message" class="no-results-message" style="display: none; padding: 10px; background-color: #d4edda; color: #155724; margin-bottom: 10px; border: 1px solid #c3e6cb; border-radius: 5px;">
  No results found for your search.
</div>



  <!-- Add Sitehead Modal -->
<div id="add-sitehead-form" class="modal">
  <div class="modal-content">
    <span class="close-form">&times;</span>
    <h2>Add New Site Head</h2>
   
    <form method="POST" action="<?php echo URLROOT; ?>/supervisor/manage_sitehead/add_sitehead" class="form-styles">
      <label for="user_id">User ID & Name:</label>
      <select name="user_id" required>
      <option value="" style="display: none;">-- Select Inactive Sitehead --</option>
  <?php if (!empty($inactiveUsers)): ?>
      <?php foreach ($inactiveUsers as $user): ?>
          <option value="<?= $user->id ?>"><?= $user->id ?> - <?= $user->full_name ?></option>
      <?php endforeach; ?>
  <?php else: ?>
      <option value="">No inactive siteheads available</option>
  <?php endif; ?>
</select>
      
      <label>Land ID:</label>
      <input type="number" name="land_id" required>

      <label>Status:</label>
      <select name="status" disabled>
        <option value="Inactive" selected>Inactive</option>
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
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
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
