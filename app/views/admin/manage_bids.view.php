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

     <!-- Manage Bids Section -->
     <div id="manage-bids-section" class="section" ">
                <center>
                    <h1>Manage Bids</h1>
                </center>
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Land ID</th>
                            <th>Crop Type</th>
                            <th>Bidder's Name</th>
                            <th>Bidding Amount</th>
                            <th>Percentage of the Harvest</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>L001</td>
                            <td>Rice</td>
                            <td>John Doe</td>
                            <td>LKR 5000</td>
                            <td>20%</td>
                            <td>
                                <button class="green-btn">Accept</button>
                                <button class="red-btn">Reject</button>
                            </td>
                        </tr>
                        <tr>
                            <td>L002</td>
                            <td>Corn</td>
                            <td>Jane Smith</td>
                            <td>LKR 4500</td>
                            <td>25%</td>
                            <td>
                                <button class="green-btn">Accept</button>
                                <button class="red-btn">Reject</button>
                            </td>
                        </tr>
                        <tr>
                            <td>L003</td>
                            <td>Wheat</td>
                            <td>Michael Brown</td>
                            <td>LKR 6000</td>
                            <td>30%</td>
                            <td>
                                <button class="green-btn">Accept</button>
                                <button class="red-btn">Reject</button>
                            </td>
                        </tr>
                        <tr>
                            <td>L004</td>
                            <td>Barley</td>
                            <td>Emily Davis</td>
                            <td>LKR 4000</td>
                            <td>15%</td>
                            <td>
                                <button class="green-btn">Accept</button>
                                <button class="red-btn">Reject</button>
                            </td>
                        </tr>
                        <tr>
                            <td>L005</td>
                            <td>Tomato</td>
                            <td>Chris Lee</td>
                            <td>LKR 3500</td>
                            <td>10%</td>
                            <td>
                                <button class="green-btn">Accept</button>
                                <button class="red-btn">Reject</button>
                            </td>
                        </tr>
                        <tr>
                            <td>L006</td>
                            <td>Carrot</td>
                            <td>Alice White</td>
                            <td>LKR 5500</td>
                            <td>18%</td>
                            <td>
                                <button class="green-btn">Accept</button>
                                <button class="red-btn">Reject</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
</body>
</html>