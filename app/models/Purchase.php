<?php

class Purchase
{
    use Model;

    protected $table = 'purchase';

    protected $allowedColumns = [
       'bid_id',
       'amount',
       'rating',
       'feedback',
       'status'
    ];

    public function getPurchasesByHarvest($harvest_id) {
        $query = "SELECT p.*, b.amount as bid_amount, b.unit_price, u.full_name as buyer_name, u.contact_no
                 FROM purchase p 
                 JOIN bid b ON p.bid_id = b.id
                 JOIN user u ON b.buyer_id = u.id
                 JOIN harvest h ON b.harvest_id = h.id
                 WHERE h.id = :harvest_id";
        return $this->query($query, ['harvest_id' => $harvest_id]);
    }

    public function markAsDelivered($purchase_id) {
        return $this->update($purchase_id, ['status' => 'Delivered']);
    }
}