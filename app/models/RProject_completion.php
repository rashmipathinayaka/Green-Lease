<?php 
class RProject_completion{
use Model;




public function getproinfobysiteheadid($id){

    $query = "
    SELECT p.* 
    FROM project p 
    JOIN sitehead s ON p.sitehead_id = s.id 
    JOIN user u ON s.user_id = u.id 
    WHERE p.status='Ongoing' AND u.id = :id
";
$data = ['id' => $id];

$result = $this->query($query, $data);
            
return $result ? $result[0] : null;



}

public function markProjectAsComplete($data)
{
    $query = "UPDATE project 
        SET 
            status = 'Completed', 
            profit = :profit, 
            description = :description 
        WHERE id = :project_id
    ";

    // Use the data passed to the function instead of $_POST directly
    $params = [
        'project_id' => $data['project_id'],
        'profit' => $data['profit_gained'],
        'description' => $data['description']
    ];

    // Execute the query
    $this->query($query, $params);
}


}















