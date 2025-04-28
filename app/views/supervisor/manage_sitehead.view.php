<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/supervisor.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="<?php echo URLROOT; ?>/assets/JS/supervisor.js" defer></script>
  <title>Manage Site Heads</title>
  <style>
    /* Page Container */
    .section-container {
      padding: 20px;
      margin-top: 60px;
    }

    /* Page Header */
    .page-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .page-header h1 {
      color: #2e7d32;
      font-size: 28px;
      font-weight: 600;
      margin: 0;
      padding-bottom: 10px;
      position: relative;
    }

    .page-header h1:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: 3px;
      background-color: #2e7d32;
    }

    /* Alert Messages */
    .alert {
      padding: 12px 20px;
      border-radius: 6px;
      margin-bottom: 20px;
      font-weight: 500;
      display: flex;
      align-items: center;
    }

    .alert i {
      margin-right: 10px;
      font-size: 18px;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .alert-error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    /* Action Bar */
    .action-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    /* Search Box */
    .search-container {
      flex: 1;
      max-width: 400px;
      position: relative;
    }

    #sitehead-search {
      width: 100%;
      padding: 12px 15px 12px 40px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 15px;
      transition: all 0.3s;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    #sitehead-search:focus {
      border-color: #2e7d32;
      box-shadow: 0 0 0 2px rgba(46, 125, 50, 0.2);
      outline: none;
    }

    .search-container:before {
      content: "🔍";
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #666;
      font-size: 16px;
    }

    /* Add Button */
    .add-button {
      background: linear-gradient(135deg, #1a472a 0%, #2e7d32 100%);
      color: white;
      border: none;
      border-radius: 8px;
      padding: 12px 20px;
      font-size: 15px;
      font-weight: 500;
      cursor: pointer;
      display: flex;
      align-items: center;
      transition: all 0.3s;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .add-button:hover {
      background: linear-gradient(135deg, #2e7d32 0%, #1a472a 100%);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .add-button i {
      margin-right: 8px;
    }

    /* No Results Message */
    .no-results-message {
      text-align: center;
      padding: 20px;
      background-color: #f9f9f9;
      border-radius: 8px;
      color: #666;
      font-size: 16px;
      margin-top: 20px;
      border: 1px dashed #ddd;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 10% auto;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      width: 500px;
      max-width: 90%;
      position: relative;
    }

    .close-form {
      position: absolute;
      top: 15px;
      right: 20px;
      color: #aaa;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
      transition: color 0.3s;
    }

    .close-form:hover {
      color: #333;
    }

    .modal h2 {
      color: #2e7d32;
      margin-top: 0;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
    }

    /* Form Styles */
    .form-styles {
      display: flex;
      flex-direction: column;
    }

    .form-styles label {
      margin-bottom: 8px;
      font-weight: 500;
      color: #333;
    }

    .form-styles select,
    .form-styles input {
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 15px;
      transition: border-color 0.3s;
    }

    .form-styles select:focus,
    .form-styles input:focus {
      border-color: #2e7d32;
      outline: none;
      box-shadow: 0 0 0 2px rgba(46, 125, 50, 0.1);
    }

    .form-styles button {
      background: linear-gradient(135deg, #1a472a 0%, #2e7d32 100%);
      color: white;
      border: none;
      padding: 12px;
      border-radius: 6px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .form-styles button:hover {
      background: linear-gradient(135deg, #2e7d32 0%, #1a472a 100%);
    }
    


  </style>
</head>

<body>
  
<?php
require ROOT . '/views/supervisor/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>

<div id="manage-site-heads-section" class="section-container">
  <div class="page-header">
    <h1>Manage Site Heads</h1>
  </div>
  
  <!-- Success message display -->
  <?php if (!empty($success)): ?>
    <div class="alert alert-success">
      <i class="fas fa-check-circle"></i>
      <?= htmlspecialchars($success) ?>
    </div>
  <?php endif; ?>
  
  <!-- Error message display -->
  <?php if (isset($error)): ?>
    <div class="alert alert-error">
      <i class="fas fa-exclamation-circle"></i>
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <div class="action-bar">
    <div class="search-container">
      <input type="text" id="sitehead-search" placeholder="Search by Name or User ID">
    </div>
    
    <button class="add-button" id="add-sitehead-btn">
      <i class="fas fa-plus-circle"></i> Assign Site Head
    </button>
  </div>

  <!-- Using the original dashboard-table class from supervisor.css -->
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
          <td>
            <span class="status-btn <?= $row->status == 'Active' ? 'active' : 'inactive' ?>">
              <?= $row->status == 'Active' ? 'Active' : 'Inactive' ?>
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
    <i class="fas fa-search"></i> No results found for your search.
  </div>

  <!-- Activate Sitehead Modal -->
  <div id="add-sitehead-form" class="modal">
    <div class="modal-content">
      <span class="close-form">&times;</span>
      <h2>Assign Site Head</h2>
     
      <form method="POST" action="<?php echo URLROOT; ?>/supervisor/manage_sitehead/add_sitehead" class="form-styles">
  <label for="user_id">Select Inactive Site Head:</label>
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
  
  <label for="land_id">Assign Land ID:</label>
  <input type="number" name="land_id" id="land_id" required>

  <input type="hidden" name="status" value="Active">

  <button type="submit">Assign Site Head</button>
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
  if (noResults && filter.length > 0) {
    noResultsMessage.style.display = "block";
  } else {
    noResultsMessage.style.display = "none";
  }
});

// Modal functionality
const modal = document.getElementById("add-sitehead-form");
const btn = document.getElementById("add-sitehead-btn");
const span = document.getElementsByClassName("close-form")[0];

btn.onclick = function() {
  modal.style.display = "block";
}

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

// Auto-hide alerts after 5 seconds
setTimeout(function() {
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(alert => {
    alert.style.display = 'none';
  });
}, 5000);
</script>

</body>

</html>
