<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/buyer.css">
    <title>Purchase History</title>
</head>
<body style="margin-top: 100px; margin-left: 20px; margin-right: 20px;">
<?php
require ROOT . '/views/buyer/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>
<div id="purchase-history-section" class="section">
    <center>
        <h1>Purchase History</h1>
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
        <tbody id="supervisor-list">
            <?php if(!empty($purchases)): ?>
                <?php foreach($purchases as $purchase): ?>
                    <tr data-id="<?php echo $purchase->id; ?>">
                        <td><?php echo date('Y-m-d', strtotime($purchase->purchase_date)); ?></td>
                        <td>LKR <?php echo number_format($purchase->amount, 2); ?></td>
                        <td><?php echo ucfirst($purchase->status); ?></td>
                        <td>
                            <button class="green-btn" data-id="<?php echo $purchase->id; ?>">View Invoice</button>
                            <button class="blue-btn">Download Invoice</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">No purchase history found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>