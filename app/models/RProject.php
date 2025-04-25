<?php

class RProject
{
    use Model;

    protected $table = 'projects';  // Table name 'projects'

    protected $allowedColumns = [
       'id',
       'supervisor_id',
       'land_id',  // Ensure correct column naming
       'duration',
       'status',
       'end_date',
       'start_date',
         'crop_type',
         'sitehead_id',
         'profit',  
            'description',
    ];

    // Method to count the number of projects for a given supervisor
    public function projectspersupervisor($supervisorId) {
        // Query to count the number of projects for a given supervisor
        $query = "SELECT COUNT(*) AS project_count FROM project WHERE supervisor_id = :supervisor_id";

        // Prepare data for binding
        $data = [':supervisor_id' => $supervisorId];
        
        // Call bind method for the query
        $this->bind($query, ':supervisor_id', $supervisorId);

        // Call the single method to execute the query and get the result
        $result = $this->single($query, $data);
        
        return $result;  // Return the result object
    }


    public function getlanddetailsbyproid($id)
    {
        $query = "SELECT * FROM land WHERE id = (SELECT land_id FROM project WHERE id = :project_id)";
        $data = ['project_id' => $id];
        $result = $this->query($query, $data);
    
        return $result ? $result[0] : null;  // return single land details
    }
    
    

//for project card
public function getprojectdetailsbyid($id){

    $query="SELECT * from project where id=:id";

    $data=['id'=>$id];
    $result= $this->query($query,$data);
    return $result ? $result[0] : null;  // return single land details

}




//get reated sitehead for project card
public function getsiteheadbyproid($id)
{
    $query = "SELECT u.* FROM sitehead s , user u WHERE s.land_id = (SELECT land_id FROM project WHERE id = :id) AND s.user_id = u.id";
    $data = ['id' => $id];
    $result = $this->query($query, $data);
    return $result ? $result[0] : null;  // returns single sitehead details
}


public function getsupervisorbyproid($id)
{
$query="SELECT u.* fROM user u,supervisor s,project  p WHERE p.id=:id AND p.supervisor_id=s.id AND s.user_id=u.id";
    $data = ['id' => $id];
    $result = $this->query($query, $data);
    return $result ? $result[0] : null;  // returns single sitehead details


}

//to submit feedback from project card
public function getfeedback($id,$feedback){
$query="INSERT INTO project_feedback (project_id, feedback) VALUES (:project_id, :feedback)";
$data=[
    'project_id'=>$id,
    'feedback'=>$feedback
];
$this->query($query,$data);

}

//admin initilaize project

public function initializeproject($formdata){
    $query="INSERT INTO project (land_id,crop_type,duration,profit,sitehead_id,status,supervisor_id,description) 
                        VALUES (:land_id,:crop_type,:duration,:profit,:sitehead_id,:status,:supervisor_id,:description)";
   
    
    
   return  $this->query($query,$formdata);
}

//enter karana land ekat kalin project ekk tyeda blnwa. tye nm aye project ekk dann be.
public function checkLandIdExists($land_id)
{
    $query = "SELECT COUNT(*) AS count FROM project WHERE land_id = :land_id";
    
    // Assuming query() returns an array of objects (stdClass)
    $result = $this->query($query, ['land_id' => $land_id]);

    // Since result is an array of objects, access the property using '->'
    return $result[0]->count > 0;  // Return true if count > 0, false otherwise
}



public function getforminfo($land_id){
    $query="SELECT * FROM land WHERE id=:land_id";
    $data=[
        'land_id'=>$land_id
    ];
    $result=$this->query($query,$data);
    return $result ? $result[0] : null;  // return single land details

}



public function getsupinfo($land_id){
    $query="SELECT * FROM site_visit WHERE id=:land_id";
    $data=[
        'land_id'=>$land_id
    ];
    $result=$this->query($query,$data);
    return $result ? $result[0] : null;  // return single land details

}



//get pending projects for admin
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
    return $result;  // returns all pending projects

}



public function approveproject($id){
    $query="UPDATE project SET status='ongoing' WHERE id=:id";
    $data=[
        'id'=>$id
    ];
    $this->query($query,$data);

}





}





