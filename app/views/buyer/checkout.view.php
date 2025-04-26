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

        document.getElementById('payment-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            document.getElementById('submit').disabled = true;
            const { error } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: { card: elements.getElement('card') }
            });
            if (error) {
                document.getElementById('payment-message').textContent = error.message;
                document.getElementById('payment-message').classList.remove('hidden');
                document.getElementById('submit').disabled = false;
            } else {
                document.getElementById('payment-message').textContent = 'Payment successful!';
                document.getElementById('payment-message').style.color = '#2e7d32';

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
        });

        initializePaymentForm();
    </script>
</body>
</html>
