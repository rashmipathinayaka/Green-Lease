<?php

class Marketplace {
    use Controller;

    public function index($a = '', $b = '', $c = '') {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['id'])) {
            header("Location: " . URLROOT . "/unauthorized");
            exit();
        }

        // Create the SHarvest model object
        $harvestModel = new SHarvest();
        
        // Apply filters if set
        $filters = [];
        
        if (isset($_GET['location']) && !empty($_GET['location'])) {
            $filters['location'] = $_GET['location'];
        }
        
        if (isset($_GET['crop_type']) && !empty($_GET['crop_type'])) {
            $filters['crop_type'] = $_GET['crop_type'];
        }
        
        // Get harvests with filters
        $harvests = $harvestModel->getFilteredHarvests($filters);
        
        // Apply sorting if set
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = $_GET['sort'];
            
            switch ($sort) {
                case 'price-asc':
                    usort($harvests, function($a, $b) {
                        return $a->min_bid - $b->min_bid;
                    });
                    break;
                case 'price-desc':
                    usort($harvests, function($a, $b) {
                        return $b->min_bid - $a->min_bid;
                    });
                    break;
                case 'date':
                    usort($harvests, function($a, $b) {
                        return strtotime($a->harvest_date) - strtotime($b->harvest_date);
                    });
                    break;
                default:
                    // No sorting
                    break;
            }
        }
        
        // Pass data to the view
        $this->view('marketplace', ['harvests' => $harvests]);
    }

    public function placeBid() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (!isset($_SESSION['id'])) {
            $_SESSION['message'] = 'Please login first';
            $_SESSION['message_type'] = 'error';
            header("Location: " . URLROOT . "/login");
            exit();
        }

        // Validate form submission
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['message'] = 'Invalid request method';
            $_SESSION['message_type'] = 'error';
            header("Location: " . URLROOT . "/marketplace");
            exit();
        }

        // Get POST data
        $harvest_id = $_POST['harvest_id'] ?? null;
        $amount = $_POST['amount'] ?? null;
        $unit_price = $_POST['unit_price'] ?? null;

        // Validate data
        if (!$harvest_id || !$amount || !$unit_price) {
            $_SESSION['message'] = 'All fields are required';
            $_SESSION['message_type'] = 'error';
            header("Location: " . URLROOT . "/marketplace");
            exit();
        }

        // Convert to integers
        $harvest_id = (int)$harvest_id;
        $amount = (int)$amount;
        $unit_price = (int)$unit_price;

        // Check if amount and price are positive
        if ($amount <= 0 || $unit_price <= 0) {
            $_SESSION['message'] = 'Amount and price must be positive';
            $_SESSION['message_type'] = 'error';
            header("Location: " . URLROOT . "/marketplace");
            exit();
        }

        // Create a bid model
        $bidModel = new SBid();
        
        // Check if amount exceeds remaining harvest amount
        $harvestModel = new SHarvest();
        $harvest = $harvestModel->getHarvestById($harvest_id);
        
        if (!$harvest) {
            $_SESSION['message'] = 'Harvest not found';
            $_SESSION['message_type'] = 'error';
            header("Location: " . URLROOT . "/marketplace");
            exit();
        }
        
        // Check if amount exceeds available (convert tons to kg)
        if ($amount > $harvest->rem_amount * 1000) {
            $_SESSION['message'] = 'Amount exceeds available harvest';
            $_SESSION['message_type'] = 'error';
            header("Location: " . URLROOT . "/marketplace");
            exit();
        }
        
        // Check if bid is above minimum
        if ($unit_price < $harvest->min_bid) {
            $_SESSION['message'] = 'Bid must be at least LKR ' . $harvest->min_bid;
            $_SESSION['message_type'] = 'error';
            header("Location: " . URLROOT . "/marketplace");
            exit();
        }

        // Submit the bid
        $result = $bidModel->createBid([
            'buyer_id' => $_SESSION['id'],
            'harvest_id' => $harvest_id,
            'amount' => $amount,
            'unit_price' => $unit_price,
            'status' => 1 // 1 = pending
        ]);

        if ($result) {
            $_SESSION['message'] = 'Bid placed successfully!';
            $_SESSION['message_type'] = 'success';
            header("Location: " . URLROOT . "/buyer");
            exit();
        } else {
            $_SESSION['message'] = 'Failed to place bid';
            $_SESSION['message_type'] = 'error';
            header("Location: " . URLROOT . "/marketplace");
            exit();
        }
    }
}