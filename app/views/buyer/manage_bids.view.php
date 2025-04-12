<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/buyer.css">

    <title>Document</title>
</head>
<body>

<?php

require ROOT . '/views/buyer/sidebar.php';
require ROOT . '/views/components/topbar.php';

?>

<div id="manage-bids-section" class="section">
                <center>
                    <h1>Manage Bids</h1>
                </center>
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Land ID</th>
                            <th>Crop Type</th>
                            <th>Bidding Amount</th>
                            <th>Percentage of the Harvest</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>101</td>
                        <td>Tea</td>
                        <td>$5,000</td>
                        <td>25%</td>
                        <td>Approved</td>
                        <td>
                            <button class="blue-btn">View Details</button>
                        </td>
                    </tr>
                    <tr>
                        <td>102</td>
                        <td>Coffee</td>
                        <td>$7,500</td>
                        <td>30%</td>
                        <td>Pending</td>
                        <td>
                            <button class="blue-btn">View Details</button>
                            <button class="red-btn">Remove Bid</button>
                        </td>
                    </tr>
                    <tr>
                        <td>103</td>
                        <td>Maize</td>
                        <td>$3,200</td>
                        <td>20%</td>
                        <td>Approved</td>
                        <td>
                            <button class="blue-btn">View Details</button>
                        </td>
                    </tr>
                    <tr>
                        <td>104</td>
                        <td>Rice</td>
                        <td>$4,800</td>
                        <td>18%</td>
                        <td>Pending</td>
                        <td>
                            <button class="blue-btn">View Details</button>
                            <button class="red-btn">Remove Bid</button>
                        </td>
                    </tr>
                    <tr>
                        <td>105</td>
                        <td>Coconut</td>
                        <td>$6,000</td>
                        <td>22%</td>
                        <td>Rejected</td>
                        <td>
                            <button class="blue-btn">View Details</button>
                            <button class="red-btn">Remove Bid</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
</body>
</html>