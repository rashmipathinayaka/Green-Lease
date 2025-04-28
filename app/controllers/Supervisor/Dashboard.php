<?php

class Dashboard
{
    use Controller;
    private $project;

    public function index()
    {
        $this->project = new Project();
        //$supervisorId = 1; 
        $supervisorId = $_SESSION['id'] ?? 1;

        // Initialize variables
        $proCount = 0;
        $completedproCount = 0;
        $ongoingProjects = [];
        $completedProjects = [];

        // If supervisor ID exists, fetch data
        if ($supervisorId) {
            $proCount = $this->project->countOngoingProjectsByUserId($supervisorId);
            $completedproCount = $this->project->countCompletedProjectsByUserId($supervisorId);
            $ongoingProjects = $this->project->findOngoingProjects($supervisorId);
            $completedProjects = $this->project->findCompletedProjects($supervisorId);
        }
        echo $proCount;

        // Send all data to the view
        $this->view('supervisor/dashboard', [
            'proCount' => $proCount,
            'completedproCount' => $completedproCount,
            'ongoingProjects' => $ongoingProjects,
            'completedProjects' =>  $completedProjects
        ]);
    }
}
