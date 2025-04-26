<?php

class SHarvest
{
    use Model;

    protected $table = 'harvest';

    protected $allowedColumns = [
       'id',
       'project_id',
       'harvest_date',
       'rem_amount',
       'max_amount',
       'min_bid',
       'bidding_start',
       'bidding_end'
    ];

    public function getAllHarvests() {
        $query = "
            SELECT 
                h.id AS harvest_id,
                h.harvest_date,
                h.max_amount,
                h.min_bid,
                h.rem_amount,
                h.bidding_start,
                h.bidding_end,
                p.crop_type,
                l.address,
                l.size,
                l.zone
            FROM harvest h
            JOIN project p ON h.project_id = p.id
            JOIN land l ON p.land_id = l.id
            WHERE l.status = 1
            AND NOW() BETWEEN h.bidding_start AND h.bidding_end
        ";

        return $this->query($query);
    }

    public function getHarvestById($id) {
        $harvests = $this->where(['id' => $id]);
        return $harvests[0] ?? null;
    }

    public function getFilteredHarvests($filters = []) {
        $query = "
            SELECT 
                h.id,
                h.harvest_date,
                h.max_amount,
                h.min_bid,
                h.rem_amount,
                h.bidding_start,
                h.bidding_end,
                p.crop_type,
                l.address,
                l.size,
                l.zone
            FROM harvest h
            JOIN project p ON h.project_id = p.id
            JOIN land l ON p.land_id = l.id
            WHERE NOW() BETWEEN h.bidding_start AND h.bidding_end
        ";
        
        $params = [];
        
        if (isset($filters['location']) && !empty($filters['location'])) {
            $query .= " AND l.address LIKE ?";
            $params[] = '%' . $filters['location'] . '%';
        }
        
        if (isset($filters['crop_type']) && !empty($filters['crop_type'])) {
            $query .= " AND p.crop_type LIKE ?";
            $params[] = '%' . $filters['crop_type'] . '%';
        }
        
        return $this->query($query, $params);
    }
}

