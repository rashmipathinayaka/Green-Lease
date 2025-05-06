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
        $query = "SELECT b.*, p.crop_type, l.address as land_location 
                 FROM bid b 
                 JOIN harvest h ON b.harvest_id = h.id 
                 JOIN project p ON h.project_id = p.id 
                 JOIN land l ON p.land_id = l.id 
                 WHERE b.buyer_id = :buyer_id";
        return $this->query($query, ['buyer_id' => $buyer_id]);
    }
    
    public function getBidsByHarvest($harvest_id) {
        return $this->where(['harvest_id' => $harvest_id]);
    }

    public function removeBid($id) {
        return $this->delete($id);
    }
}