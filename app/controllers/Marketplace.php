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

        $harvestModel = new SHarvest();
        
        $filters = [];
        
        if (isset($_GET['location']) && !empty($_GET['location'])) {
            $filters['location'] = $_GET['location'];
        }
        
        if (isset($_GET['crop_type']) && !empty($_GET['crop_type'])) {
            $filters['crop_type'] = $_GET['crop_type'];
        }
        
        $harvests = $harvestModel->getFilteredHarvests($filters);
        
        if ($harvests && is_array($harvests)) {
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
                        break;
                }
            }
        } else {
            $harvests = [];
        }
        
        $this->view('marketplace', ['harvests' => $harvests]);
    }

    public function placeBid() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['id'])) {
            $_SESSION['message'] = 'Please login first';
            $_SESSION['message_type'] = 'error';
            header("Location: " . URLROOT . "/login");
            exit();
        }

        $bidModel = new SBid();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData = [
                'buyer_id' => $_SESSION['id'],
                'harvest_id' => $_POST['harvest_id'] ?? null,
                'amount' => $_POST['amount'] ?? null,
                'unit_price' => $_POST['unit_price'] ?? null,
                'status' => 'Pending'
            ];

            if (!$formData['harvest_id'] || !$formData['amount'] || !$formData['unit_price']) {
                $_SESSION['message'] = 'All fields are required';
                $_SESSION['message_type'] = 'error';
                header("Location: " . URLROOT . "/marketplace");
                exit();
            }

            $formData['harvest_id'] = (int)$formData['harvest_id'];
            $formData['amount'] = (int)$formData['amount'];
            $formData['unit_price'] = (int)$formData['unit_price'];

            if ($formData['amount'] <= 0 || $formData['unit_price'] <= 0) {
                $_SESSION['message'] = 'Amount and price must be positive';
                $_SESSION['message_type'] = 'error';
                header("Location: " . URLROOT . "/marketplace");
                exit();
            }

            $harvestModel = new SHarvest();
            $harvest = $harvestModel->getHarvestById($formData['harvest_id']);
            
            if (!$harvest) {
                $_SESSION['message'] = 'Harvest not found';
                $_SESSION['message_type'] = 'error';
                header("Location: " . URLROOT . "/marketplace");
                exit();
            }

            $now = new DateTime();
            $bidding_start = new DateTime($harvest->bidding_start);
            $bidding_end = new DateTime($harvest->bidding_end);

            if ($now < $bidding_start || $now > $bidding_end) {
                $_SESSION['message'] = 'Bidding period is not active';
                $_SESSION['message_type'] = 'error';
                header("Location: " . URLROOT . "/marketplace");
                exit();
            }

            if ($formData['amount'] > $harvest->rem_amount * 1000) {
                $_SESSION['message'] = 'Amount exceeds available harvest';
                $_SESSION['message_type'] = 'error';
                header("Location: " . URLROOT . "/marketplace");
                exit();
            }

            if ($formData['unit_price'] < $harvest->min_bid) {
                $_SESSION['message'] = 'Bid must be at least LKR ' . $harvest->min_bid;
                $_SESSION['message_type'] = 'error';
                header("Location: " . URLROOT . "/marketplace");
                exit();
            }

            if ($bidModel->createBid($formData)) {
                $_SESSION['message'] = 'Bid placed successfully! Your bid of LKR ' . number_format($formData['unit_price']) . ' per kg for ' . number_format($formData['amount']) . ' kg has been submitted.';
                $_SESSION['message_type'] = 'success';
                header("Location: " . URLROOT . "/marketplace");
                exit();
            } else {
                $_SESSION['message'] = 'Failed to place bid. Please try again.';
                $_SESSION['message_type'] = 'error';
                header("Location: " . URLROOT . "/marketplace");
                exit();
            }
        } else {
            $_SESSION['message'] = 'Invalid request method';
            $_SESSION['message_type'] = 'error';
            header("Location: " . URLROOT . "/marketplace");
            exit();
        }
    }
} 