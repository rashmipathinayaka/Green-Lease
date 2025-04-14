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
       'max_amount'
       
    ];

    public function getAllHarvests() {
        $query = "
            SELECT 
                h.id AS harvest_id,
                h.harvest_date,
                h.max_amount,
                h.min_bid,
                h.rem_amount,
                p.crop_type,
                l.address,
                l.size,
                l.zone
            FROM harvest h
            JOIN project p ON h.project_id = p.id
            JOIN land l ON p.land_id = l.id
            WHERE l.status = 1
        ";

        return $this->query($query);
    }
    // Add this method to your SHarvest model
// Add these methods to your SHarvest model

public function getHarvestById($id) {
    $harvests = $this->where(['id' => $id]);
    return $harvests[0] ?? null;
}

public function getFilteredHarvests($filters = []) {
    $query = "SELECT * FROM $this->table WHERE 1=1";
    $params = [];
    
    if (isset($filters['location']) && !empty($filters['location'])) {
        $query .= " AND address LIKE ?";
        $params[] = '%' . $filters['location'] . '%';
    }
    
    if (isset($filters['crop_type']) && !empty($filters['crop_type'])) {
        $query .= " AND crop_type LIKE ?";
        $params[] = '%' . $filters['crop_type'] . '%';
    }
    
    return $this->query($query, $params);
}
    
}

