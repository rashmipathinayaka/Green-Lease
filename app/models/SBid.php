<?php
// models/Bid.php
class SBid {
    use Model;
    
    protected $table = 'bid';
    protected $allowedColumns = [
        'buyer_id',
        'harvest_id',
        'amount',
        'unit_price',
        'status',
        'bidding_date'
    ];

    public function createBid($data) {
        return $this->insert($data);
    }
    
    public function getBidsByBuyer($buyer_id) {
        return $this->where(['buyer_id' => $buyer_id]);
    }
    
    public function getBidsByHarvest($harvest_id) {
        return $this->where(['harvest_id' => $harvest_id]);
    }
}