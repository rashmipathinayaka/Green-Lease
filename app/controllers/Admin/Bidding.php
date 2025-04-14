<?php
class Bidding
{
    use Controller;

    private $bidding;
    private $capacity;

    public function __construct()
    {
        // Initialize the Bid and Harvest models in the constructor
        $this->bidding = new RBid();
        $this->capacity = new RHarvest();
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $harvest_id = $_POST['harvest_id'];
    
            // Fetch the capacity for the given harvest_id
            $capacity = $this->capacity->getCapacity($harvest_id);
    
            if ($capacity === null) {
                echo "Capacity not found for harvest_id: $harvest_id";
                return;
            }
    
            // Fetch biddings for the given harvest_id using the Knapsack algorithm
            $biddings = $this->bidding->getBiddingsByHarvestId($harvest_id, $capacity);
    
            // Pass the data to the view
            $this->view('admin/bidding', ['biddings' => $biddings]);
        } else {
            echo "Invalid request method.";
        }
    }
}