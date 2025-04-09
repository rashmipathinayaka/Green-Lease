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
}

