<?php
class Bidding
{
    use Controller;

    private $bidding;
    private $harvest;

    public function __construct()
    {
        $this->bidding = new RBid();
        $this->harvest = new RHarvest();
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['harvest_id'])) {
            $harvest_id = $_POST['harvest_id'] ?? $_GET['harvest_id'];
    
            $capacity = $this->harvest->getCapacity($harvest_id);
            $rem_amount = $this->harvest->getRemainingAmount($harvest_id);
    
            if ($capacity === null || $rem_amount === null) {
                echo "Capacity or remaining amount not found for harvest_id: $harvest_id";
                return;
            }
    
            $biddings = $this->bidding->getBiddingsByHarvestId($harvest_id, $capacity);
    
            $this->view('admin/bidding', [
                'biddings' => $biddings,
                'max_amount' => $capacity,
                'rem_amount' => $rem_amount,
                'harvest_id' => $harvest_id
            ]);
        } else {
            echo "Invalid request method.";
        }
    }
    


    public function GetRemHarvest($id)
    {
        $this->harvest->calculate_remharvest($id);
        // Don’t redirect here — handled by JS
    }


    public function approveBid()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $harvest_id = $_POST['harvest_id'];
            $bid_id = $_POST['bid_id']; 

            $bid = $this->harvest->getBidById($bid_id);

            if ($bid === null) {
                echo "Bid not found!";
                return;
            }

            $remaining_amount = $this->harvest->getRemainingAmount($harvest_id);
            if ($bid->amount > $remaining_amount) {
                echo "Bid exceeds remaining capacity!";
                return;
            }

            $this->harvest->approveBid($bid_id);

            $this->harvest->reduceRemainingAmount($harvest_id, $bid->amount);

            header("Location: " . URLROOT . "/Admin/Bidding?harvest_id=$harvest_id");
                                exit;
        }
    }
}
