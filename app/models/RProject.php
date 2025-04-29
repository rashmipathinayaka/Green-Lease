<?php

class RProject
{
    use Model;

    protected $table = 'projects';  

    protected $allowedColumns = [
       'id',
       'supervisor_id',
       'land_id',  
       'duration',
       'status',
       'end_date',
       'start_date',
         'crop_type',
         'sitehead_id',
         'profit_rate',  
            'description',
            'profit',
    ];

    public function projectspersupervisor($supervisorId) {
        $query = "SELECT COUNT(*) AS project_count FROM project WHERE supervisor_id = :supervisor_id";

        $data = [':supervisor_id' => $supervisorId];
        
        $this->bind($query, ':supervisor_id', $supervisorId);

        $result = $this->single($query, $data);
        
        return $result;  
    }


    public function getlanddetailsbyproid($id)
    {
        $query = "SELECT * FROM land WHERE id = (SELECT land_id FROM project WHERE id = :project_id)";
        $data = ['project_id' => $id];
        $result = $this->query($query, $data);
    
        return $result ? $result[0] : null;  
    }
    
    

//for project card
public function getprojectdetailsbyid($id){

    $query="SELECT * from project where id=:id";

    $data=['id'=>$id];
    $result= $this->query($query,$data);
    return $result ? $result[0] : null;  

}




public function getsiteheadbyproid($id)
{
    $query = "SELECT u.* 
    FROM project p 
    JOIN sitehead s ON p.sitehead_id = s.id 
    JOIN user u ON s.user_id = u.id 
    WHERE p.id = :id";
$data = ['id' => $id];
    $result = $this->query($query, $data);
    return $result ? $result[0] : null; 
}


public function getsupervisorbyproid($id)
{
$query="SELECT u.* fROM user u,supervisor s,project  p WHERE p.id=:id AND p.supervisor_id=s.id AND s.user_id=u.id";
    $data = ['id' => $id];
    $result = $this->query($query, $data);
    return $result ? $result[0] : null; 

}


public function getfeedback($id,$feedback){
$query="INSERT INTO project_feedback (project_id, feedback) VALUES (:project_id, :feedback)";
$data=[
    'project_id'=>$id,
    'feedback'=>$feedback
];
$this->query($query,$data);

}



public function initializeproject($formdata){
    $query="INSERT INTO project (land_id,crop_type,duration,profit_rate,sitehead_id,status,supervisor_id,description) 
                        VALUES (:land_id,:crop_type,:duration,:profit,:sitehead_id,:status,:supervisor_id,:description)";
   
    
    
   return  $this->query($query,$formdata);
}

public function checkLandIdExists($land_id)
{
    $query = "SELECT COUNT(*) AS count FROM project WHERE land_id = :land_id";
    
    $result = $this->query($query, ['land_id' => $land_id]);

    return $result[0]->count > 0;  
}



public function getforminfo($land_id){
    $query="SELECT * FROM land WHERE id=:land_id";
    $data=[
        'land_id'=>$land_id
    ];
    $result=$this->query($query,$data);
    return $result ? $result[0] : null;  

}



public function getsupinfo($land_id){
    $query="SELECT * FROM site_visit WHERE id=:land_id";
    $data=[
        'land_id'=>$land_id
    ];
    $result=$this->query($query,$data);
    return $result ? $result[0] : null;  

}




public function getpendingprojects()
{
    $query="SELECT  p.*, 
    sv.id AS visit_id, 
    l.zone, 
    z.zone_name, 
    l.crop_type, 
    p.crop_type AS selected_crop
FROM 
    project p
JOIN 
    site_visit sv ON p.land_id = sv.land_id
JOIN 
    land l ON p.land_id = l.id
JOIN 
    zone z ON l.zone = z.id
WHERE 
    p.status = 'pending'";
    $result = $this->query($query);
    return $result; 

}



public function approveproject($id) {
    $query = "UPDATE project SET status='ongoing' WHERE id=:id";
    $data = [
        'id' => $id
    ];
    $this->query($query, $data); 

    $query = "SELECT sitehead_id FROM project WHERE id=:id";
    $result = $this->query($query, $data); 
    
    
    if ($result && isset($result[0]->sitehead_id)) {
        $sitehead_id = $result[0]->sitehead_id;

        $query = "UPDATE sitehead SET status='active' WHERE id=:sitehead_id";
        $data = [
            'sitehead_id' => $sitehead_id
        ];
        $this->query($query, $data); 
    }
}



public function getsupervisoridbyuserid($user_id) {
    $query = "SELECT s.id FROM supervisor s WHERE s.user_id = :user_id";
    $data = ['user_id' => $user_id];
    
    $result = $this->query($query, $data);

    if (!empty($result)) {
        return $result[0]->id; 
    }
    
    return null;
}







public function checksupervisorOfVisit($land_id, $supervisor_id) {
    $query = "SELECT id FROM site_visit WHERE land_id = :land_id AND supervisor_id = :supervisor_id";
    $data = [
        'land_id' => $land_id,
        'supervisor_id' => $supervisor_id
    ];
    $result = $this->query($query, $data);

    return !empty($result); 
}


public function rejectproject($formdata){
    // Prepare the query to update the outcome and reason for the site visit
    $query = "UPDATE site_visit SET outcome = 'Rejected', reason = :reason WHERE id = :id";

    // Prepare the data to bind to the query
    $data = [
        'id' => $formdata['id'],
        'reason' => $formdata['reason']
    ];

    // Execute the query with the data
    return $this->query($query, $data);
}



}

















