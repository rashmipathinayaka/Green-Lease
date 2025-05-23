<?php

class Payment
{
    use Controller;
    
    public function __construct() {}

    public function create_payment_intent()
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $stripeSecretKey = getenv('STRIPE_SECRET_KEY');
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);
        $amount = $input['amount']; 
        $bid_id = $input['bid_id'];

        $fields = [
            'amount' => $amount * 100, 
            'currency' => 'lkr',
            'payment_method_types[]' => 'card',
            'metadata[bid_id]' => $bid_id
        ];

        $ch = curl_init('https://api.stripe.com/v1/payment_intents');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $stripeSecretKey,
            'Content-Type: application/x-www-form-urlencoded',
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));

        $response = curl_exec($ch);

        if ($response === false) {
            echo json_encode(['error' => 'Stripe API call failed: ' . curl_error($ch)]);
            curl_close($ch);
            return;
        }

        curl_close($ch);

        echo $response; 
    }

    public function checkout($bid_id)
    {

        $bidModel = new SBid();
        $payment = $bidModel->first(['id' => $bid_id]);
        if (!$payment) {
            die('Invalid payment/bid.');
        }
        $stripe_publishable_key = getenv('STRIPE_PUBLISHABLE_KEY');
        $this->view('buyer/checkout', [
            'payment' => $payment,
            'stripe_publishable_key' => $stripe_publishable_key
        ]);
    }

    public function record_purchase()
    {

        $input = json_decode(file_get_contents('php://input'), true);
        $bid_id = $input['bid_id'];

        $bidModel = new SBid();
        $bid = $bidModel->first(['id' => $bid_id]);
        if (!$bid) {
            echo json_encode(['success' => false, 'error' => 'Bid not found']);
            return;
        }

        $total_amount = $bid->amount * $bid->unit_price;

        $purchaseModel = new Purchase();
        $purchaseModel->insert([
            'bid_id' => $bid->id,
            'amount' => $total_amount
        ]);

        echo json_encode(['success' => true]);
    }
}

