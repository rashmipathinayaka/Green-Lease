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
        'status'
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

    public function delete($id)
{
    // Prepare the SQL query to delete the bid
    $sql = "DELETE FROM bid WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

}