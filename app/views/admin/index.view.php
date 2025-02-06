<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="admin.js" defer></script>

</head>

<body>
<?php

require ROOT . '/views/admin/sidebar.php';
require ROOT . '/views/components/navbar.php';

?>

    <div class="admin-container">
       
        <div class="content">
            <div id="dashboard-section" class="section">
                <div class="metric-grid">
                    <div class="metric-card">
                        <h3>Registered Lands</h3>
                        <div class="metric-content">
                            <span class="metric-value">27</span>
                            <i class="fas fa-seedling"></i>
                        </div>
                        <button onclick="showSection('manage-lands-section')">View</button>
                    </div>
                    <div class="metric-card">
                        <h3>Supervisor Count</h3>
                        <div class="metric-content">
                            <span class="metric-value">20</span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button onclick="showSection('manage-supervisors-section')">View</button>
                    </div>
                    <div class="metric-card">
                        <h3>Total Bids</h3>
                        <div class="metric-content">
                            <span class="metric-value">40</span>
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <button onclick="showSection('manage-bids-section')">View</button>
                    </div>
                    <div class="metric-card">
                        <h3>Buyer Count</h3>
                        <div class="metric-content">
                            <span class="metric-value">240</span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button onclick="showSection('manage-buyers-section')">View</button>
                    </div>
                </div>

                <center>
                    <h1>Pending Approvals</h1>
                </center>
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Land ID</th>
                            <th>Location</th>
                            <th>Crop Type</th>
                            <th>Lease Duration</th>
                            <th>Field Visit Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>LD1234</td>
                            <td>Moratuwa</td>
                            <td>Orchid</td>
                            <td>1 Year</td>
                            <td>2024-09-20</td>
                            <td>
                                <button class="green-btn">Accept</button>
                                <button class="red-btn">Reject</button>
                            </td>
                        </tr>
                        <tr>
                            <td>LD1235</td>
                            <td>Panadura</td>
                            <td>Anthurium</td>
                            <td>6 Months</td>
                            <td>2024-09-23</td>
                            <td>
                                <button class="green-btn">Accept</button>
                                <button class="red-btn">Reject</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

           

            

           

      
     
    </div>
</body>

</html>