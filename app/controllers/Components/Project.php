<?php

class Project
{
    use Controller;
private $eventmodel;
private $project;
private $sitehead;
    // Constructor to initialize the model
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
        $eventdetails = $this->eventmodel->geteventdetailsbyid($id); // returns array
    
        // Decode completion_images for each event
        foreach ($eventdetails as $key => $event) {
            $eventdetails[$key]->images = json_decode($event->completion_images);
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
    
    // Get the feedback from POST data
    $this->project->getfeedback($id,$feedback);

    header('Location: ' . URLROOT . '/Components/project/index/' . $id);

}
}