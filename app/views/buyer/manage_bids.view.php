<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/buyer.css">
    <title>Manage Bids</title>
</head>
<body style="margin-top: 100px; margin-left: 20px; margin-right: 20px;">
    <?php
    require ROOT . '/views/buyer/sidebar.php';
    require ROOT . '/views/components/topbar.php';
    ?>

    <div id="manage-bids-section" class="section">
        <center>
            <h1>Manage Bids</h1>
        </center>
        
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?>">
                <?= $_SESSION['message'] ?>
            </div>
            <?php 
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>

        <table class="dashboard-table">
            <thead>
                <tr>
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
                                <button class="green-btn" onclick="viewBidDetails(<?php echo $bid->id; ?>)">View Details</button>
                                <?php if($bid->status === 'Pending'): ?>
                                    <button class="red-btn" onclick="confirmRemoveBid(<?php echo $bid->id; ?>)">Remove Bid</button>
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

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="confirmation-modal">
        <div class="confirmation-modal-content">
            <div class="confirmation-modal-header">
                <h3>Confirm Bid Removal</h3>
            </div>
            <div class="confirmation-modal-body">
                <p>Are you sure you want to remove this bid? This action cannot be undone.</p>
            </div>
            <div class="confirmation-modal-footer">
                <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                <button type="button" class="confirm-btn" onclick="removeBid()">Confirm Remove</button>
            </div>
        </div>
    </div>

    <script>
        let currentBidId = null;

        function confirmRemoveBid(bidId) {
            currentBidId = bidId;
            document.getElementById('confirmationModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('confirmationModal').style.display = 'none';
            currentBidId = null;
        }

        function removeBid() {
            if (currentBidId) {
                window.location.href = '<?= URLROOT ?>/Buyer/Manage_bids/removeBid/' + currentBidId;
            }
        }

        function viewBidDetails(bidId) {
            // Implement view details functionality
            alert('View details functionality will be implemented soon.');
        }

        // Close modal if clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('confirmationModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>