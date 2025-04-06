<?php

class Harvest
{
    use Model;

    protected $table = 'harvest';

    protected $allowedColumns = [
       'id',
       
       'project-id',
       
       'harvest_date',
       'rem_amount',
       'max_amount'
       
    ];

public function findAll()
{
    $query = "select * from harvest ";

		return $this->query($query);
}

public function getCapacity($harvest_id)
    {
        // Prepare the SQL query
        $query = "SELECT capacity FROM harvest WHERE harvest_id = :harvest_id";

        // Bind the parameter
        $data = [':harvest_id' => $harvest_id];

        // Execute the query
        $result = $this->query($query, $data);

        // Return the capacity if found, otherwise return null
        return $result ? (int) $result[0]->capacity : null;
    }
}

