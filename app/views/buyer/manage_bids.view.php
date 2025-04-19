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
                            <!-- <th>Land ID</th> -->
                            <th>Harvest ID</th>
                            <th>Bidding Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($bids)): ?>
                <?php foreach($bids as $bid): ?>
                    <tr data-id="<?php echo $bid->id; ?>">
                        <td><?php echo $bid->harvest_id; ?></td>
                        <td>LKR <?php echo $bid->amount; ?></td>
                        <td><?php echo ucfirst($bid->status); ?></td>
                        <td>
                            <button class="green-btn" data-id="<?php echo $bid->id; ?>">View Details</button>
                            <?php if (strtolower($bid->status) === 'pending'): ?>
                                <button class="red-btn" onclick="openModal('<?= URLROOT ?>/Worker/Manage_bids/removeBid/<?php echo $bid->id; ?>')">Remove Bid</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">No Bids Found</td>
                </tr>
            <?php endif; ?>
                    </tbody>
                </table>
            </div>
</body>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.red-btn').forEach(button => {
        button.addEventListener('click', function () {
            const bidId = this.getAttribute('data-id');
            console.log("Attempting to remove bid with ID:", bidId);

            if (confirm('Are you sure you want to remove this bid?')) {
                fetch('<?php echo URLROOT; ?>/manage_bids/remove/' + bidId, {
                    method: 'POST'
                })
                .then(res => {
                    if (res.ok) {
                        alert('Bid removed successfully!');
                        location.reload(); // refresh after deletion
                    } else {
                        alert('Failed to remove bid.');
                    }
                })
                .catch(err => {
                    console.error("Fetch error:", err);
                    alert('Error occurred while removing the bid.');
                });
            }
        });
    });
});
</script>


</html>