<?php

class Project
{
    use Controller;
private $eventmodel;
private $project;
private $sitehead;

public function __construct()
    {
        $this->eventmodel = new REvent;
        $this->project = new RProject;
        $this->sitehead = new RSitehead;
    }
    public function index($id)
    {
        $proimage = $this->eventmodel->geteventimage($id);
        $landdetails = $this->project->getlanddetailsbyproid($id);
        $projectdetails = $this->project->getprojectdetailsbyid($id);
        $eventdetails = $this->eventmodel->geteventdetailsbyid($id); 
    
        if (is_array($eventdetails)) {
            foreach ($eventdetails as $key => $event) {
                $eventdetails[$key]->images = json_decode($event->completion_images ?: '[]');
            }
        } else {
            $eventdetails = [];
        }
        
     
        $sitehead = $this->project->getsiteheadbyproid($projectdetails->id);
        $supervisor = $this->project->getsupervisorbyproid($projectdetails->id);
   
        $data = [
            'landdetails' => $landdetails,
            'proimage' => $proimage,
            'projectdetails' => $projectdetails,
            'eventdetails' => $eventdetails,
            'sitehead' => $sitehead,
            'supervisor' => $supervisor
        ];
    
        $this->view('components/project', $data);
    }
    

public function getfeedback($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $feedback = trim($_POST['feedback'] ?? '');  }  
    
    $this->project->getfeedback($id,$feedback);

    header('Location: ' . URLROOT . '/Components/project/index/' . $id);

}
}