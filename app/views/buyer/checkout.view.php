<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/buyer.css">
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Poppins', Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            min-width: 800px;
        }
        .checkout-container {
            max-width: 800px;
            margin: 60px auto;
            padding: 36px 32px 32px 32px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px #0002;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .checkout-container h2 {
            font-weight: 600;
            margin-bottom: 12px;
            color: #2e7d32;
        }
        .checkout-amount {
            font-size: 1.2rem;
            font-weight: 500;
            margin-bottom: 24px;
            color: #333;
        }
        #payment-form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        #card-element {
            padding: 14px;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            background: #fafafa;
            margin-bottom: 0;
        }
        .green-btn {
            background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
            color: #fff;
            border: none;
            padding: 12px 0;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px #38f9d733;
            margin: 0 auto;
        }
        .green-btn:disabled {
            background: #bdbdbd;
            cursor: not-allowed;
        }
        #payment-message {
            margin-top: 10px;
            color: #b71c1c;
            font-size: 0.98rem;
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            display: none;
        }
        #payment-message.success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
            display: block;
            animation: fadeIn 0.5s ease-in-out;
        }
        #payment-message.error {
            background: #ffebee;
            color: #b71c1c;
            border: 1px solid #ef9a9a;
            display: block;
            animation: fadeIn 0.5s ease-in-out;
        }
        .card-icons {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            justify-content: center;
        }
        .card-icons img {
            height: 28px;
            opacity: 0.7;
        }
        .secure-text {
            font-size: 0.95rem;
            color: #888;
            margin-top: 8px;
            text-align: center;
            display: flex;
            align-items: center;
            gap: 6px;
            justify-content: center;
        }
        .secure-text i {
            color: #2e7d32;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .success-icon {
            color: #2e7d32;
            font-size: 24px;
            margin-right: 8px;
        }
        .confirmation-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .confirmation-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 24px;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .confirmation-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 20px;
        }
        .confirm-btn {
            background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }
        .cancel-btn {
            background: #f44336;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }
        .payment-details {
            background: #f8f9fa;
            padding: 16px;
            border-radius: 8px;
            margin: 16px 0;
        }
        .payment-details p {
            margin: 8px 0;
            color: #333;
        }
        .payment-details strong {
            color: #2e7d32;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <h2>Complete Your Payment</h2>
        <div class="checkout-amount">Amount: <span style="color:#2e7d32;">LKR <?= number_format($payment->amount * $payment->unit_price, 2) ?></span></div>
        <div class="card-icons">
            <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa">
            <img src="https://img.icons8.com/color/48/000000/mastercard-logo.png" alt="Mastercard">
            <img src="https://img.icons8.com/color/48/000000/amex.png" alt="Amex">
        </div>
        <form id="payment-form">
            <div id="card-element"></div>
            <button id="submit" class="green-btn">
                <span id="button-text">Pay now</span>
                <span id="spinner" class="spinner hidden"></span>
            </button>
            <div id="payment-message" class="hidden"></div>
        </form>
        <div class="secure-text"><i class="fa fa-lock"></i> 100% Secure Payment</div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="confirmation-modal">
        <div class="confirmation-content">
            <h3>Confirm Payment</h3>
            <div class="payment-details">
                <p><strong>Amount:</strong> LKR <?= number_format($payment->amount * $payment->unit_price, 2) ?></p>
                <p><strong>Quantity:</strong> <?= $payment->amount ?> kg</p>
                <p><strong>Unit Price:</strong> LKR <?= number_format($payment->unit_price, 2) ?> per kg</p>
            </div>
            <p>Are you sure you want to proceed with this payment?</p>
            <div class="confirmation-buttons">
                <button class="cancel-btn" onclick="closeConfirmation()">Cancel</button>
                <button class="confirm-btn" onclick="proceedWithPayment()">Confirm Payment</button>
            </div>
        </div>
    </div>

    <script>
        const stripe = Stripe('<?= $stripe_publishable_key ?>');
        let elements, clientSecret;

        async function initializePaymentForm() {
            const response = await fetch('<?= URLROOT ?>/Buyer/Payment/create_payment_intent', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    amount: <?= $payment->amount * $payment->unit_price ?>,
                    bid_id: <?= $payment->id ?>
                })
            });
            const data = await response.json();
            if (!data.client_secret) {
                document.getElementById('payment-message').textContent = 'Error: ' + (data.error || 'No client_secret');
                document.getElementById('payment-message').classList.remove('hidden');
                return;
            }
            clientSecret = data.client_secret;
            elements = stripe.elements({ clientSecret });
            const card = elements.create('card', {
                style: {
                    base: {
                        fontSize: '17px',
                        color: '#222',
                        fontFamily: 'Poppins, Arial, sans-serif',
                        '::placeholder': { color: '#bdbdbd' }
                    },
                    invalid: { color: '#e53935', iconColor: '#e53935' }
                }
            });
            card.mount('#card-element');
        }

        document.getElementById('payment-form').addEventListener('submit', function(e) {
            e.preventDefault();
            document.getElementById('confirmationModal').style.display = 'block';
        });

        function closeConfirmation() {
            document.getElementById('confirmationModal').style.display = 'none';
        }

        async function proceedWithPayment() {
            document.getElementById('confirmationModal').style.display = 'none';
            document.getElementById('submit').disabled = true;
            
            const { error } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: { card: elements.getElement('card') }
            });
            
            if (error) {
                document.getElementById('payment-message').textContent = error.message;
                document.getElementById('payment-message').className = 'error';
                document.getElementById('submit').disabled = false;
            } else {
                document.getElementById('payment-message').innerHTML = '<i class="fas fa-check-circle success-icon"></i> Payment successful! Redirecting to dashboard...';
                document.getElementById('payment-message').className = 'success';

                // Record purchase in backend
                fetch('<?= URLROOT ?>/Buyer/Payment/record_purchase', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ bid_id: <?= $payment->id ?> })
                }).then(() => {
                    setTimeout(() => {
                        window.location.href = '<?= URLROOT ?>/Buyer/index';
                    }, 1500);
                });
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == document.getElementById('confirmationModal')) {
                closeConfirmation();
            }
        }

        initializePaymentForm();
    </script>
</body>
</html>
