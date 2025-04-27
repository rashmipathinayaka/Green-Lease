<?php

class Dashboard
{
    use Controller;
    private $project;

    public function index()
    {
        $this->project = new Project();
        $supervisorId = 1; // supervisor_id = $_SESSION['id']) 

        // Initialize variables
        $proCount = 0;
        $completedproCount = 0;
        $projects = [];
        $projectz = [];

        // If supervisor ID exists, fetch data
        if ($supervisorId) {
            $proCount = $this->project->countOngoingProjectsBySupervisorId($supervisorId);
            $completedproCount = $this->project->countCompletedProjectsBySupervisorId($supervisorId);
            $projects = $this->project->findOngoingProjects($supervisorId);
            $projectz = $this->project->findCompletedProjects($supervisorId);
        }

        // Send all data to the view
        $this->view('supervisor/index', [
            'proCount' => $proCount,
            'completedproCount' => $completedproCount,
            'projects' => $projects,
            'projectz' => $projectz
        ]);
    }
}
