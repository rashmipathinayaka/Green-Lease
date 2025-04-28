<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard</title>
    <link rel="stylesheet" href="<?= URLROOT; ?>/assets/css/buyer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://js.stripe.com/v3/"></script>
    <!-- <script src="buyer.js" defer></script> -->
</head>

<body>

<?php
$activePage = 'dashboard';
require ROOT . '/views/buyer/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>

    <div class="admin-container">
       
        <div class="content">
            <div id="dashboard-section" class="section">
            <div class="welcome-container">
				<div class="welcome-header">
					<h1>Hello, <span class="username"><?= htmlspecialchars($sname) ?></span> ! 👋</h1>
					<p class="welcome-message">Welcome back to your dashboard</p>
				</div>
			</div>
                <div class="metric-grid">
                    <div class="metric-card">
                        <h3>Pending Payments</h3>
                        <div class="metric-content">
                            <span class="metric-value"><?= $pending_payments_count ?></span>
                            <i class="fas fa-user"></i>
                        </div>
                        <a href="<?= URLROOT ?>/Buyer/Index"><button>View</button></a>
                    </div>
                    <div class="metric-card">
                        <h3>Bids Placed</h3>
                        <div class="metric-content">
                            <span class="metric-value"><?= $bids_placed_count ?></span>
                            <i class="fas fa-user"></i>
                        </div>
                        <a href="<?= URLROOT ?>/Buyer/Manage_bids"><button>View</button></a>
                    </div>
                    <div class="metric-card">
                        <h3>Total Purchases</h3>
                        <div class="metric-content">
                            <span class="metric-value"><?= $total_purchases_count ?></span>
                            <i class="fas fa-user"></i>
                        </div>
                        <a href="<?= URLROOT ?>/Buyer/Purchase_history"><button>View</button></a>
                    </div>
                </div>

                <center>
                    <h1>Pending Payments</h1>
                </center>
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Bid Approval Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($pending_payments)): ?>
                            <?php foreach($pending_payments as $payment): ?>
                                <tr>
                                    <td><?= $payment->bidding_date ?></td>
                                    <td>LKR <?= number_format($payment->amount * $payment->unit_price, 2) ?></td>
                                    <td><?= $payment->status ?></td>
                                    <td>
                                        <a href="<?= URLROOT ?>/Buyer/Payment/checkout/<?= $payment->id ?>">
                                            <button class="green-btn">Pay</button>
                                        </a>
                                        <button class="red-btn" onclick="cancelOrder(<?= $payment->id ?>)">Cancel Order</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">No pending payments</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

          

            
        </div>
    </div>    

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
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        #card-element {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(0,0,0,.1);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .hidden {
            display: none;
        }

        #payment-message {
            color: #dc3545;
            margin-top: 10px;
        }
    </style>
</body>
</html>