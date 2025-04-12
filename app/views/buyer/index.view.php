<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard</title>
    <link rel="stylesheet" href="<?= URLROOT; ?>/assets/css/buyer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- <script src="buyer.js" defer></script> -->
</head>

<body>

<?php
require ROOT . '/views/buyer/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>

    <div class="admin-container">
       
        <div class="content">
            <div id="dashboard-section" class="section">
                <div class="metric-grid">
                    <div class="metric-card">
                        <h3>Heading 1</h3>
                        <div class="metric-content">
                            <span class="metric-value">Value 1</span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button>View</button>
                    </div>
                    <div class="metric-card">
                        <h3>Heading 2</h3>
                        <div class="metric-content">
                            <span class="metric-value">Value 2</span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button>View</button>
                    </div>
                    <div class="metric-card">
                        <h3>Heading 3</h3>
                        <div class="metric-content">
                            <span class="metric-value">Value 3</span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button>View</button>
                    </div>
                    <div class="metric-card">
                        <h3>Heading 4</h3>
                        <div class="metric-content">
                            <span class="metric-value">Value 4</span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button>View</button>
                    </div>
                </div>

                <center>
                    <h1>Pending Payments</h1>
                </center>
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Purchase Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2021-10-10</td>
                            <td>LKR 25 000</td>
                            <td>Pending Payment</td>
                            <td>
                                <button class="green-btn">Pay</button>
                                <button class="red-btn">Cancel Order</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2024-10-10</td>
                            <td>LKR 42 000</td>
                            <td>Pending Payment</td>
                            <td>
                                <button class="green-btn">Pay</button>
                                <button class="red-btn">Cancel Order</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

          

            
        </div>
    </div>    
</body>
</html>