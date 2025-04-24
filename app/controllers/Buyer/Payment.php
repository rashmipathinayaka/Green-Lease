<?php

class Payment
{
    use Controller;

    public function __construct()
    {
        if (!isset($_SESSION['id'])) {
            redirect('login');
        }
    }

    public function create_payment_intent()
    {
        // Prevent any HTML output
        ob_clean();
        
        // Set JSON header
        header('Content-Type: application/json');

        try {
            // Get JSON input
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON data received');
            }

            // Debug log
            error_log('Received payment data: ' . print_r($data, true));

            // Get the amount from the JSON data
            $amount = $data['amount'] ?? 0;
            $bid_id = $data['bid_id'] ?? null;

            if (!$amount || !$bid_id) {
                throw new Exception('Amount and bid ID are required');
            }

            // Format amount properly and ensure it's an integer
            $amount_in_cents = (int)($amount * 100);

            if ($amount_in_cents < 1) {
                throw new Exception('Invalid amount');
            }

            // Debug log
            error_log('Creating payment intent for amount: ' . $amount_in_cents);

            // Prepare the request to Stripe API
            $ch = curl_init('https://api.stripe.com/v1/payment_intents');
            
            // Disable SSL verification for development
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . STRIPE_SECRET_KEY,
                'Content-Type: application/x-www-form-urlencoded'
            ]);
            
            $postData = http_build_query([
                'amount' => $amount_in_cents,
                'currency' => 'lkr',
                'metadata' => [
                    'bid_id' => $bid_id,
                    'buyer_id' => $_SESSION['id']
                ],
                'automatic_payment_methods' => ['enabled' => true]
            ]);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

            // Debug log
            error_log('Stripe API request data: ' . $postData);

            $response = curl_exec($ch);
            
            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);
                throw new Exception('Curl error: ' . $error);
            }

            // Debug log
            error_log('Stripe API response: ' . $response);
            
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200) {
                $error = json_decode($response, true);
                throw new Exception($error['error']['message'] ?? 'Failed to create payment intent');
            }

            $result = json_decode($response, true);
            
            if (!isset($result['client_secret'])) {
                throw new Exception('No client secret in Stripe response');
            }

            // Return the client secret
            echo json_encode([
                'clientSecret' => $result['client_secret']
            ]);
            exit;
        } catch (Exception $e) {
            error_log('Payment intent error: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    public function handle_webhook()
    {
        // Prevent any HTML output
        ob_clean();
        
        // Set JSON header
        header('Content-Type: application/json');

        try {
            $payload = @file_get_contents('php://input');
            $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
            
            // Verify webhook signature
            $expected_sig = hash_hmac('sha256', $payload, STRIPE_WEBHOOK_SECRET);
            if (!hash_equals($expected_sig, $sig_header)) {
                throw new Exception('Invalid signature');
            }

            $event = json_decode($payload, true);
            
            // Handle the event
            switch ($event['type']) {
                case 'payment_intent.succeeded':
                    $paymentIntent = $event['data']['object'];
                    $this->handle_successful_payment($paymentIntent);
                    break;
                case 'payment_intent.payment_failed':
                    $paymentIntent = $event['data']['object'];
                    $this->handle_failed_payment($paymentIntent);
                    break;
            }

            echo json_encode(['status' => 'success']);
            exit;
        } catch (Exception $e) {
            error_log('Webhook error: ' . $e->getMessage());
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    private function handle_successful_payment($paymentIntent)
    {
        $bid_id = $paymentIntent['metadata']['bid_id'];
        $buyer_id = $paymentIntent['metadata']['buyer_id'];

        // Update bid status to 'Paid'
        $bidModel = new SBid();
        $bidModel->update($bid_id, ['status' => 'Paid']);

        // Create a purchase record
        $purchase = new Purchase();
        $purchase->insert([
            'buyer_id' => $buyer_id,
            'harvest_id' => $bidModel->first(['id' => $bid_id])->harvest_id,
            'amount' => $paymentIntent['amount'] / 100 // Convert back to dollars
        ]);
    }

    private function handle_failed_payment($paymentIntent)
    {
        $bid_id = $paymentIntent['metadata']['bid_id'];
        
        // Update bid status to 'Payment Failed'
        $bidModel = new SBid();
        $bidModel->update($bid_id, ['status' => 'Payment Failed']);
    }
} 