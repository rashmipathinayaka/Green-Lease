<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/buyer.css">
    <title>Manage Bids</title>
    <style>
        /* Tab Navigation Styles */
        .tab-navigation {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .tab-btn {
            padding: 10px 20px;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 16px;
            color: #666;
            transition: all 0.3s ease;
        }

        .tab-btn.active {
            color: #2e7d32;
            border-bottom: 2px solid #2e7d32;
            margin-bottom: -12px;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Filter Form Styles */
        .filter-form {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-form select,
        .filter-form input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .filter-form button {
            padding: 8px 16px;
            background-color: #2e7d32;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .filter-form button:hover {
            background-color: #1b5e20;
        }
    </style>
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

        <!-- Tab Navigation -->
        <div class="tab-navigation">
            <button class="tab-btn active" onclick="switchTabs(this, 'active-bids')">Active Bids</button>
            <button class="tab-btn" onclick="switchTabs(this, 'bid-history')">Bid History</button>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="" class="filter-form">
            <select name="status" id="status">
                <option value="">All Status</option>
                <option value="Pending" <?= (isset($_GET['status']) && $_GET['status'] === 'Pending') ? 'selected' : '' ?>>Pending</option>
                <option value="Approved" <?= (isset($_GET['status']) && $_GET['status'] === 'Approved') ? 'selected' : '' ?>>Approved</option>
                <option value="Not Approved" <?= (isset($_GET['status']) && $_GET['status'] === 'Not Approved') ? 'selected' : '' ?>>Not Approved</option>
                <option value="Rejected (No Payment)" <?= (isset($_GET['status']) && $_GET['status'] === 'Rejected (No Payment)') ? 'selected' : '' ?>>Rejected (No Payment)</option>
            </select>

            <input type="date" name="date_from" value="<?= isset($_GET['date_from']) ? htmlspecialchars($_GET['date_from']) : '' ?>" placeholder="From Date">
            <input type="date" name="date_to" value="<?= isset($_GET['date_to']) ? htmlspecialchars($_GET['date_to']) : '' ?>" placeholder="To Date">

            <button type="submit">Apply Filters</button>
        </form>

        <!-- Active Bids Tab -->
        <div id="active-bids" class="tab-content active">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Harvest ID</th>
                        <th>Amount (kg)</th>
                        <th>Unit Price (LKR)</th>
                        <th>Status</th>
                        <th>Bidding Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($active_bids)): ?>
                        <?php foreach($active_bids as $bid): ?>
                            <tr data-id="<?php echo $bid->id; ?>" 
                                data-amount="<?php echo $bid->amount; ?>"
                                data-unit-price="<?php echo $bid->unit_price; ?>">
                                <td><?php echo $bid->harvest_id; ?></td>
                                <td><?php echo $bid->amount; ?> kg</td>
                                <td>LKR <?php echo $bid->unit_price; ?></td>
                                <td><?php echo ucfirst($bid->status); ?></td>
                                <td><?php echo $bid->bidding_date; ?></td>
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
                            <td colspan="6" style="text-align: center;">No Active Bids Found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Bid History Tab -->
        <div id="bid-history" class="tab-content">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Harvest ID</th>
                        <th>Amount (kg)</th>
                        <th>Unit Price (LKR)</th>
                        <th>Status</th>
                        <th>Bidding Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($bid_history)): ?>
                        <?php foreach($bid_history as $bid): ?>
                            <tr data-id="<?php echo $bid->id; ?>" 
                                data-amount="<?php echo $bid->amount; ?>"
                                data-unit-price="<?php echo $bid->unit_price; ?>">
                                <td><?php echo $bid->harvest_id; ?></td>
                                <td><?php echo $bid->amount; ?> kg</td>
                                <td>LKR <?php echo $bid->unit_price; ?></td>
                                <td><?php echo ucfirst($bid->status); ?></td>
                                <td><?php echo $bid->bidding_date; ?></td>
                                <td>
                                    <button class="green-btn" onclick="viewBidDetails(<?php echo $bid->id; ?>)">View Details</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No Bid History Found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
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

    <!-- Bid Details Modal -->
    <div id="bidDetailsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Bid Details</h2>
            </div>
            <div class="modal-body">
                <div class="bid-details">
                    <p><strong>Harvest ID:</strong> <span id="viewHarvestId"></span></p>
                    <p><strong>Amount:</strong> <span id="viewAmount"></span> kg</p>
                    <p><strong>Unit Price:</strong> LKR <span id="viewUnitPrice"></span> per kg</p>
                    <p><strong>Total Value:</strong> LKR <span id="viewTotalValue"></span></p>
                    <p><strong>Status:</strong> <span id="viewStatus"></span></p>
                    <p><strong>Bidding Date:</strong> <span id="viewBiddingDate"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="cancel-btn" onclick="closeBidDetailsModal()">Close</button>
            </div>
        </div>
    </div>

    <script>
        let currentBidId = null;

        function switchTabs(button, tabId) {
            // Remove active class from all tabs and buttons
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked button and corresponding tab
            button.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        }

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
            // Get the bid row data
            const bidRow = document.querySelector(`tr[data-id="${bidId}"]`);
            const harvestId = bidRow.children[0].textContent;
            const amount = parseFloat(bidRow.dataset.amount);
            const unitPrice = parseFloat(bidRow.dataset.unitPrice);
            const status = bidRow.children[3].textContent;
            const biddingDate = bidRow.children[4].textContent;

            // Calculate total value
            const totalValue = amount * unitPrice;

            // Update modal content
            document.getElementById('viewHarvestId').textContent = harvestId;
            document.getElementById('viewAmount').textContent = amount.toLocaleString();
            document.getElementById('viewUnitPrice').textContent = unitPrice.toLocaleString();
            document.getElementById('viewTotalValue').textContent = totalValue.toLocaleString();
            document.getElementById('viewStatus').textContent = status;
            document.getElementById('viewBiddingDate').textContent = biddingDate;

            // Show the modal
            document.getElementById('bidDetailsModal').style.display = 'block';
        }

        function closeBidDetailsModal() {
            document.getElementById('bidDetailsModal').style.display = 'none';
        }

        // Close modal if clicking outside
        window.onclick = function(event) {
            const bidDetailsModal = document.getElementById('bidDetailsModal');
            const confirmationModal = document.getElementById('confirmationModal');
            
            if (event.target == bidDetailsModal) {
                closeBidDetailsModal();
            }
            if (event.target == confirmationModal) {
                closeModal();
            }
        }
    </script>

    <!-- Add these styles to the existing CSS -->
    <style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 90%;
        max-width: 500px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .modal-header {
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .modal-body {
        margin-bottom: 20px;
    }

    .bid-details {
        margin: 10px 0;
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 4px;
    }

    .bid-details p {
        margin: 8px 0;
    }

    .modal-footer {
        border-top: 1px solid #ddd;
        padding-top: 10px;
        text-align: right;
    }

    .modal-footer button {
        margin-left: 10px;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
    }
    </style>
</body>
</html>