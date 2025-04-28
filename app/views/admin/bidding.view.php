<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(URLROOT); ?>/assets/css/admin/manage-bids.css">
    <title>Biddings</title>

</head>

<body style="margin-top: 20px; margin-left: 20px; margin-right: 20px;">
    <?php
    require ROOT . '/views/admin/sidebar.php';
    require ROOT . '/views/components/topbar.php';

    // Getting the max harvest amount and remaining amount
    // These values would typically come from your database

    $max_amount = $data['max_amount'];
    $remaining_amount = $data['rem_amount'];
    $used_amount = $max_amount - $remaining_amount;
    $percentage_used = ($used_amount / $max_amount) * 100;
    ?>
    <script>
        const harvestId = <?= json_encode($data['harvest_id']) ?>;
    </script>

    <div class="bidding-header">
        <h2>The bids are arranged in the order which gives the highest profit</h2>
    </div>

    <!-- Progress bar showing harvest capacity -->
    <div class="progress-container">
        <h3>Harvest Capacity</h3>
        <div class="progress-info">
            <span>Used: <?= number_format($used_amount) ?> kg</span>
            <span>Available: <?= number_format($remaining_amount) ?> kg</span>
            <span>Total: <?= number_format($max_amount) ?> kg</span>
        </div>
        <div class="progress-bar-container">
            <div class="progress-bar" style="width: <?= $percentage_used ?>%">
                <span class="progress-text"><?= round($percentage_used) ?>% Used</span>
            </div>
        </div>
    </div>

    <table class="dashboard-table">
        <thead>
            <tr>
                <th>Buyer ID</th>
                <th>Bid ID</th>
                <th>Amount (KG)</th>
                <th>Unit Price (LKR)</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="supervisor-list">
            <?php if (!empty($biddings)): ?>
                <?php foreach ($biddings as $bid): ?>
                    <?php if ($bid !== null): ?>
                        <tr data-bid-id="<?= htmlspecialchars($bid->id) ?>">
                            <td><?= htmlspecialchars($bid->buyer_id) ?></td>
                            <td><?= htmlspecialchars($bid->id) ?></td>
                            <td><?= htmlspecialchars($bid->amount) ?></td>
                            <td><?= htmlspecialchars($bid->unit_price) ?></td>
                            <td><?= htmlspecialchars($bid->status) ?></td>
                            <td>
                                <?php if ($bid->status === 'Pending'): ?>
                                    <button class="green-btn" onclick="showApprovalModal(<?= htmlspecialchars($bid->id) ?>, <?= htmlspecialchars($bid->amount) ?>, <?= $remaining_amount ?>)">Approve</button>
                                <?php else: ?>
                                    <!-- <button class="blue-btn">View</button> -->
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="no-data">No bids available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Modal for approval confirmation -->
    <div id="approvalModal" class="rmodal">
        <div class="rmodal-content">
            <div class="rmodal-header">
                <h3>Confirm Approval</h3>
                <span class="close-btn" onclick="closeModal()">&times;</span>
            </div>
            <div class="rmodal-body">
                <p>Bid Amount: <span id="modalBidAmount">0</span> kg</p>
                <p>Remaining Capacity: <span id="modalRemainingAmount">0</span> kg</p>

                <div class="progress-bar-container" style="margin-top: 15px;">
                    <div id="modalProgressBar" class="progress-bar" style="width: 0%">
                        <span class="progress-text">0%</span>
                    </div>
                </div>

                <p id="capacityWarning" style="color: red; margin-top: 10px; display: none;">
                    Warning: This bid exceeds the remaining capacity!
                </p>
            </div>
            <div class="rmodal-actions">
                <button onclick="closeModal()" class="red-btn">Cancel</button>
                <button id="confirmApproveBtn" class="green-btn">Confirm Approval</button>
            </div>
        </div>
    </div>

    <script>
        // Function to show the approval modal
        function showApprovalModal(bidId, bidAmount, remainingAmount) {
            const modal = document.getElementById('approvalModal');
            const modalBidAmount = document.getElementById('modalBidAmount');
            const modalRemainingAmount = document.getElementById('modalRemainingAmount');
            const modalProgressBar = document.getElementById('modalProgressBar');
            const capacityWarning = document.getElementById('capacityWarning');
            const confirmBtn = document.getElementById('confirmApproveBtn');

            // Set values in modal
            modalBidAmount.textContent = bidAmount;
            modalRemainingAmount.textContent = remainingAmount;

            // Calculate what percentage of the remaining capacity this bid represents
            const percentOfRemaining = (bidAmount / remainingAmount) * 100;
            modalProgressBar.style.width = Math.min(percentOfRemaining, 100) + '%';
            modalProgressBar.querySelector('.progress-text').textContent =
                Math.round(Math.min(percentOfRemaining, 100)) + '%';

            // Change progress bar color based on capacity
            if (percentOfRemaining > 100) {
                modalProgressBar.style.background = 'linear-gradient(90deg, #FF5252, #FF1744)';
                capacityWarning.style.display = 'block';
                confirmBtn.disabled = true;
            } else if (percentOfRemaining > 80) {
                modalProgressBar.style.background = 'linear-gradient(90deg, #FFC107, #FF9800)';
                capacityWarning.style.display = 'none';
                confirmBtn.disabled = false;
            } else {
                modalProgressBar.style.background = 'linear-gradient(90deg, #4CAF50, #8BC34A)';
                capacityWarning.style.display = 'none';
                confirmBtn.disabled = false;
            }

            // Set confirm button action
            confirmBtn.onclick = function() {
                // Create and submit the form dynamically
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?= URLROOT ?>/Admin/Bidding/approveBid'; // Make sure this matches your controller route

                const harvestInput = document.createElement('input');
                harvestInput.type = 'hidden';
                harvestInput.name = 'harvest_id';
                harvestInput.value = harvestId;
                form.appendChild(harvestInput);

                const bidInput = document.createElement('input');
                bidInput.type = 'hidden';
                bidInput.name = 'bid_id';
                bidInput.value = bidId; // Pass bid ID here
                form.appendChild(bidInput);

                document.body.appendChild(form);
                form.submit();
            };

            // Show the modal
            modal.style.display = 'block';
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('approvalModal').style.display = 'none';
        }

        // Close modal if user clicks outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('approvalModal');
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>

    


</body>

</html>