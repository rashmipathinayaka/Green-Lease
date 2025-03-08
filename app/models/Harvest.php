<?php

class Harvest
{
    use Model;

    protected $table = 'harvests';

    protected $allowedColumns = [
       'harvest_id',
       'buyer-id',
       'project-id',
       'amount',
       'harvest_date',
       'capacity',
       
    ];

public function findAll()
{
    $query = "select * from harvests ";

		return $this->query($query);
}

public function getCapacity($harvest_id)
    {
        // Prepare the SQL query
        $query = "SELECT capacity FROM harvests WHERE harvest_id = :harvest_id";

        // Bind the parameter
        $data = [':harvest_id' => $harvest_id];

        // Execute the query
        $result = $this->query($query, $data);

        // Return the capacity if found, otherwise return null
        return $result ? (int) $result[0]->capacity : null;
    }
}

