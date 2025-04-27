<?php
class RBuyer{


use Model;


public function getbuyerdetails(){

$query="SELECT * FROM user where role_id=5";
$result=$this->query($query);

return $result;

}

public function getBuyerbyid($id) {
    $query = 'SELECT * from user where id = :id'; 
    $data = [':id' => $id]; // Bind the id parameter

    // Assuming query() returns an array of results
    $result = $this->query($query, $data);
    
    // Return the first result or null if not found
    return $result ? $result[0] : null;
}


}