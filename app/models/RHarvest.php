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


    public function calculate_remharvest($id) {
        // First update rem_amount in harvest
        $query1 = 'UPDATE harvest h
                   JOIN bid b ON h.id = b.harvest_id
                   SET h.rem_amount = h.max_amount - b.amount
                   WHERE b.id = :id AND b.status = "Pending"';
    
        // Then update the bid status to Approved
        $query2 = 'UPDATE bid SET status = "Approved" WHERE id = :id';
    
        $data = [':id' => $id];
    
        // Execute both queries
        $this->query($query1, $data);
        return $this->query($query2, $data);
    }




    public function getHarvestIdByBidId($bid_id) {
        $query = "SELECT harvest_id FROM bid WHERE id = :id";
        $data = [':id' => $bid_id];
        $result = $this->query($query, $data);
        return $result ? (int) $result[0]->harvest_id : null;
}    



public function getRemainingAmount($harvest_id)
{
    $query = "SELECT rem_amount FROM harvest WHERE id = :harvest_id";
    $result = $this->query($query, ['harvest_id' => $harvest_id]);
    
    return $result ? (float) $result[0]->rem_amount : null;
}





public function reduceRemainingAmount($harvest_id, $amount)
{
    // Sanitize input to avoid SQL injection by using parameterized queries
    $query = "UPDATE harvest SET rem_amount = rem_amount - :amount WHERE id = :harvest_id";
    
    // Create the data array with values
    $data = [
        ':amount' => $amount, 
        ':harvest_id' => $harvest_id
    ];

    // Execute the query with the provided parameters
    return $this->query($query, $data);
}


public function getBidById($bid_id)
{
    // Query to fetch the bid details by ID
    $query = "SELECT * FROM bid WHERE id = :bid_id";
    
    // Prepare the data array for the query
    $data = [':bid_id' => $bid_id];
    
    // Execute the query
    $result = $this->query($query, $data);

    // Return the result if found, or null if not
    return $result ? $result[0] : null;
}


public function approveBid($bid_id)
{
    // SQL query to update the bid status to "Approved"
    $query = "UPDATE bid SET status = 'Approved' WHERE id = :bid_id";
    
    // Prepare the data array for the query
    $data = [':bid_id' => $bid_id];
    
    // Execute the query
    $result = $this->query($query, $data);

    // Return true if the query executed successfully, false otherwise
    return $result !== false;
}


}