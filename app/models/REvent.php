



<?php

class REvent
{
    use Model;

    protected $table = 'event';

    protected $allowedColumns = [
        'id',
        'event_name',
        'project_id',
        'date',
        'status',
        'description',
        'progress_notes',
        'completion_status',
        'completion_images'
    ];








public function geteventimage($id){

$query="SELECT completion_images FROM event WHERE project_id=:project_id"; 
$data=['project_id'=>$id];
 return $this->query($query,$data);


    }


    public function geteventdetailsbyid($id)
    {
        $query = "SELECT * FROM event WHERE project_id = :project_id ORDER BY date ASC"; // or DESC
        $data = ['project_id' => $id];
        return $this->query($query, $data); // returns an array of events
    }
    






}




