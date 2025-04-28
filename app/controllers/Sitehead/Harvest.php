<?php
require_once __DIR__ . '/../../core/Controller.php';

class Harvest {

    use Controller;
    
    private $purchaseModel;

    public function __construct() {
        $auth = Auth::getInstance();
        if (!$auth->isLoggedIn() || !$auth->hasRole(3)) {
            redirect('unauthorized');
        }
        
        $this->purchaseModel = new Purchase();
    }

    public function index() {
        // Get all purchases with their associated harvest and buyer information
        $query = "SELECT p.*, b.amount as bid_amount, b.unit_price, b.harvest_id, 
                         h.harvest_date, h.max_amount, h.rem_amount,
                         u.full_name as buyer_name, u.contact_no
                 FROM purchase p 
                 JOIN bid b ON p.bid_id = b.id
                 JOIN harvest h ON b.harvest_id = h.id
                 JOIN user u ON b.buyer_id = u.id
                 ORDER BY p.status ASC, h.harvest_date DESC";
        
        $purchases = $this->purchaseModel->query($query);
        
        // Group purchases by status
        $pendingPurchases = array_filter($purchases, function($purchase) {
            return $purchase->status !== 'Delivered';
        });
        
        $deliveredPurchases = array_filter($purchases, function($purchase) {
            return $purchase->status === 'Delivered';
        });
        
        $data = [
            'pendingPurchases' => array_values($pendingPurchases),
            'deliveredPurchases' => array_values($deliveredPurchases)
        ];
        
        $this->view('sitehead/harvest', $data);
    }

    public function markDelivered($purchaseId) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->purchaseModel->markAsDelivered($purchaseId)) {
                $_SESSION['message'] = 'Purchase marked as delivered successfully';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Failed to mark purchase as delivered';
                $_SESSION['message_type'] = 'error';
            }
            redirect('Sitehead/Harvest');
        }
    }
} 