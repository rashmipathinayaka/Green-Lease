<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/sitehead.css">
    <title>Harvest Management</title>
    <style>
        .event-badge {
            background-color: #e0e0e0;
            border-radius: 12px;
            padding: 2px 8px;
            margin: 2px;
            display: inline-block;
            font-size: 12px;
        }

        .event-badge.approved {
            background-color: #d4edda;
            color: #155724;
        }

        .delivery-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 6px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 13px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
            white-space: nowrap;
            min-width: 120px;
        }

        .delivery-btn:hover {
            background-color: #45a049;
        }

        .complete-project-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 20px auto;
            cursor: pointer;
            border-radius: 4px;
            white-space: nowrap;
            min-width: 200px;
        }

        .complete-project-btn:hover {
            background-color: #45a049;
        }

        .button-container {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body style="margin-top: 100px; margin-left: 20px; margin-right: 20px;">

    <?php
    require ROOT . '/views/sitehead/sidebar.php';
    require ROOT . '/views/components/topbar.php';
    ?>

    <div id="harvest-section" class="section">
        <center>
            <h1>Purchase Management</h1>
        </center>
        <br><br>

        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?>">
                <?= $_SESSION['message'] ?>
            </div>
            <?php 
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>

        <!-- Pending Purchases -->
        <div class="filter-section">
            <h2>Pending Purchases</h2>
        </div>
        <?php if(empty($data['pendingPurchases'])): ?>
            <p class="text-muted">No pending purchases found.</p>
        <?php else: ?>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Purchase ID</th>
                        <th>Buyer Name</th>
                        <th>Contact No</th>
                        <th>Amount</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                        <th>Harvest Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['pendingPurchases'] as $purchase): ?>
                        <tr>
                            <td><?= $purchase->id ?></td>
                            <td><?= $purchase->buyer_name ?></td>
                            <td><?= $purchase->contact_no ?></td>
                            <td><?= $purchase->bid_amount ?> kg</td>
                            <td>LKR <?= $purchase->unit_price ?></td>
                            <td>LKR <?= $purchase->amount ?></td>
                            <td><?= date('M d, Y', strtotime($purchase->harvest_date)) ?></td>
                            <td>
                                <form method="POST" action="<?= URLROOT ?>/Sitehead/Harvest/markDelivered/<?= $purchase->id ?>" style="display: inline;">
                                    <button type="submit" class="delivery-btn">Mark Delivered</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- Delivered Purchases -->
        <div class="filter-section">
            <h2>Delivered Purchases</h2>
        </div>
        <?php if(empty($data['deliveredPurchases'])): ?>
            <p class="text-muted">No delivered purchases found.</p>
        <?php else: ?>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Purchase ID</th>
                        <th>Buyer Name</th>
                        <th>Contact No</th>
                        <th>Amount</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                        <th>Harvest Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['deliveredPurchases'] as $purchase): ?>
                        <tr>
                            <td><?= $purchase->id ?></td>
                            <td><?= $purchase->buyer_name ?></td>
                            <td><?= $purchase->contact_no ?></td>
                            <td><?= $purchase->bid_amount ?> kg</td>
                            <td>LKR <?= $purchase->unit_price ?></td>
                            <td>LKR <?= $purchase->amount ?></td>
                            <td><?= date('M d, Y', strtotime($purchase->harvest_date)) ?></td>
                            <td><span class="event-badge approved">Delivered</span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="button-container">
        <a href="<?= URLROOT ?>/sitehead/project_completion" class="complete-project-btn">Complete Project</a>
    </div>

</body>
</html> 