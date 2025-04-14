<?php

class RHarvest
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

public function findAll()
{
    $query = "select * from harvest ";

		return $this->query($query);
}

public function getCapacity($harvest_id)
    {
        // Prepare the SQL query
        $query = "SELECT max_amount FROM harvest WHERE id = :id";

        // Bind the parameter
        $data = [':id' => $harvest_id];

        // Execute the query
        $result = $this->query($query, $data);

        // Return the capacity if found, otherwise return null
        return $result ? (int) $result[0]->max_amount : null;
    }
}

