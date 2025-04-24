<?php
class Bid extends Model
{
    protected $table = 'bids';
    protected $allowedColumns = [
        'id',
        'harvest_id',
        'buyer_id',
        'amount',
        'unit_price',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getBidsByBuyerId($buyer_id, $statuses = [], $filter_status = '', $date_from = '', $date_to = '')
    {
        $query = "SELECT b.*, h.title as harvest_title, h.quantity as harvest_quantity, h.unit as harvest_unit 
                 FROM {$this->table} b 
                 JOIN harvests h ON b.harvest_id = h.id 
                 WHERE b.buyer_id = :buyer_id";

        $params = [':buyer_id' => $buyer_id];

        if (!empty($statuses)) {
            $placeholders = implode(',', array_fill(0, count($statuses), '?'));
            $query .= " AND b.status IN ($placeholders)";
            $params = array_merge($params, $statuses);
        }

        if (!empty($filter_status)) {
            $query .= " AND b.status = :filter_status";
            $params[':filter_status'] = $filter_status;
        }

        if (!empty($date_from)) {
            $query .= " AND DATE(b.created_at) >= :date_from";
            $params[':date_from'] = $date_from;
        }

        if (!empty($date_to)) {
            $query .= " AND DATE(b.created_at) <= :date_to";
            $params[':date_to'] = $date_to;
        }

        $query .= " ORDER BY b.created_at DESC";

        return $this->query($query, $params);
    }

    public function removeBid($id)
    {
        $bid = $this->first(['id' => $id]);
        if (!$bid || $bid->status !== 'Pending') {
            return false;
        }
        return $this->delete($id);
    }
} 