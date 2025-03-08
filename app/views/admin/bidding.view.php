<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin/manage-bids.css">
    <title>Biddings</title>
</head>
<body>

<?php

require ROOT . '/views/admin/sidebar.php';
require ROOT . '/views/components/navbar.php';

?>
<h2 font color='green'> The bids are arranged in the order which gives the highest profit </h2>

    <table class="dashboard-table">
        <thead>
            <tr>
                <th>Buyer ID</th>
                <th>Bid ID</th>
                <th>Amount</th>
                <th>Unit Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="supervisor-list">
            <?php if (!empty($biddings)): ?>
                <?php foreach ($biddings as $bid): ?>
                    <?php if ($bid !== null): ?> <!-- Skip null rows -->
                        <tr data-bid-id="<?= htmlspecialchars($bid->bid_id) ?>">
                            <td><?= htmlspecialchars($bid->buyer_id) ?></td>
                            <td><?= htmlspecialchars($bid->bid_id) ?></td>
                            <td><?= htmlspecialchars($bid->amount) ?></td>
                            <td><?= htmlspecialchars($bid->unit_price) ?></td>
                            <td>
                                <?= $bid->status === 'pending' ? "Pending" : "Approved" ?>
                            </td>
                            <td>
                                <?php if ($bid->status === 'pending'): ?>
                                    <button class="green-btn" onclick="window.location.href='<?php echo URLROOT; ?>/admin/Manage_land/updateland/<?php echo $bid->bid_id; ?>';">Approve</button>
                                <?php else: ?>
                                    <button class="red-btn">View</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No bids available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>