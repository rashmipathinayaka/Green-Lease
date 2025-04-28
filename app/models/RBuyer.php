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
    $data = [':id' => $id]; 


    $result = $this->query($query, $data);
    
    
    return $result ? $result[0] : null;
}


}