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
require ROOT . '/views/buyer/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>

    <div class="admin-container">
       
        <div class="content">
            <div id="dashboard-section" class="section">
                <div class="metric-grid">
                    <div class="metric-card">
                        <h3>Heading 1</h3>
                        <div class="metric-content">
                            <span class="metric-value">Value 1</span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button>View</button>
                    </div>
                    <div class="metric-card">
                        <h3>Heading 2</h3>
                        <div class="metric-content">
                            <span class="metric-value">Value 2</span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button>View</button>
                    </div>
                    <div class="metric-card">
                        <h3>Heading 3</h3>
                        <div class="metric-content">
                            <span class="metric-value">Value 3</span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button>View</button>
                    </div>
                    <div class="metric-card">
                        <h3>Heading 4</h3>
                        <div class="metric-content">
                            <span class="metric-value">Value 4</span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button>View</button>
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
                                        <button class="green-btn" onclick="initiatePayment(<?= $payment->id ?>, <?= $payment->amount * $payment->unit_price ?>)">Pay</button>
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

    <!-- Payment Modal -->
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Complete Payment</h2>
                <span class="close" onclick="closePaymentModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="payment-form">
                    <div id="card-element">
                        <!-- Stripe Elements will be inserted here -->
                    </div>
                    <button id="submit" class="green-btn">
                        <span id="button-text">Pay now</span>
                        <span id="spinner" class="spinner hidden"></span>
                    </button>
                    <div id="payment-message" class="hidden"></div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('<?= STRIPE_PUBLISHABLE_KEY ?>');
        let elements;
        let currentBidId;
        let currentAmount;
        let clientSecret;

        function initiatePayment(bidId, amount) {
            currentBidId = bidId;
            currentAmount = amount;
            document.getElementById('paymentModal').style.display = 'block';
            initializePaymentForm();
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').style.display = 'none';
            if (elements) {
                elements.getElement('card').unmount();
            }
        }

        async function initializePaymentForm() {
            try {
                // Create payment intent
                const response = await fetch('<?= URLROOT ?>/Buyer/Payment/create_payment_intent', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        amount: currentAmount,
                        bid_id: currentBidId
                    })
                });

                const data = await response.json();
                console.log('Payment intent response:', data); // Debug log

                if (data.error) {
                    throw new Error(data.error);
                }
                
                if (!data.clientSecret) {
                    throw new Error('No client secret received from the server');
                }

                clientSecret = data.clientSecret;

                // Initialize Stripe Elements
                elements = stripe.elements({ clientSecret });
                const card = elements.create('card', {
                    style: {
                        base: {
                            fontSize: '16px',
                            color: '#32325d',
                            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                            '::placeholder': {
                                color: '#aab7c4'
                            }
                        },
                        invalid: {
                            color: '#fa755a',
                            iconColor: '#fa755a'
                        }
                    }
                });
                
                // Clear previous card element if it exists
                const cardElement = document.getElementById('card-element');
                cardElement.innerHTML = '';
                
                card.mount('#card-element');

                // Handle real-time validation errors
                card.addEventListener('change', function(event) {
                    const displayError = document.getElementById('payment-message');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                        displayError.classList.remove('hidden');
                    } else {
                        displayError.textContent = '';
                        displayError.classList.add('hidden');
                    }
                });

            } catch (error) {
                console.error('Payment form initialization error:', error); // Debug log
                showMessage(error.message || 'An error occurred while initializing the payment form.');
            }
        }

        async function handleSubmit(e) {
            e.preventDefault();
            setLoading(true);

            try {
                if (!elements) {
                    throw new Error('Payment form not properly initialized');
                }

                const { error } = await stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        return_url: '<?= URLROOT ?>/Buyer/Index',
                    },
                });

                if (error) {
                    throw error;
                }
            } catch (error) {
                console.error('Payment submission error:', error); // Debug log
                showMessage(error.message || 'An error occurred while processing your payment.');
                setLoading(false);
            }
        }

        function setLoading(isLoading) {
            const submitButton = document.getElementById('submit');
            const spinner = document.getElementById('spinner');
            const buttonText = document.getElementById('button-text');

            if (isLoading) {
                submitButton.disabled = true;
                spinner.classList.remove('hidden');
                buttonText.classList.add('hidden');
            } else {
                submitButton.disabled = false;
                spinner.classList.add('hidden');
                buttonText.classList.remove('hidden');
            }
        }

        function showMessage(messageText) {
            const messageContainer = document.getElementById('payment-message');
            messageContainer.classList.remove('hidden');
            messageContainer.textContent = messageText;
        }

        function cancelOrder(bidId) {
            if (confirm('Are you sure you want to cancel this order?')) {
                window.location.href = '<?= URLROOT ?>/Buyer/Manage_bids/removeBid/' + bidId;
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('paymentModal');
            if (event.target == modal) {
                closePaymentModal();
            }
        }

        // Add form submission handler
        document.getElementById('payment-form').addEventListener('submit', handleSubmit);
    </script>

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