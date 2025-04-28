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
        
        $query = "SELECT max_amount FROM harvest WHERE id = :id";

    
        $data = [':id' => $harvest_id];

        
        $result = $this->query($query, $data);

        
        return $result ? (int) $result[0]->max_amount : null;
    }


    public function calculate_remharvest($id) {
        
        $query1 = 'UPDATE harvest h
                   JOIN bid b ON h.id = b.harvest_id
                   SET h.rem_amount = h.max_amount - b.amount
                   WHERE b.id = :id AND b.status = "Pending"';
    
        
        $query2 = 'UPDATE bid SET status = "Approved" WHERE id = :id';
    
        $data = [':id' => $id];
    
    
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
    $query = "UPDATE harvest SET rem_amount = rem_amount - :amount WHERE id = :harvest_id";
    
    $data = [
        ':amount' => $amount, 
        ':harvest_id' => $harvest_id
    ];

    return $this->query($query, $data);
}


public function getBidById($bid_id)
{
    $query = "SELECT * FROM bid WHERE id = :bid_id";
    
    $data = [':bid_id' => $bid_id];
    
    $result = $this->query($query, $data);

    return $result ? $result[0] : null;
}


public function approveBid($bid_id)
{
    $query = "UPDATE bid SET status = 'Approved' WHERE id = :bid_id";
    
    $data = [':bid_id' => $bid_id];
    
    $result = $this->query($query, $data);
    return $result !== false;
}










}




