<?php

class Dashboard
{
    use Controller;
    private $projects;

    public function index()
    {
        $this->projects = new Project();
        $supervisorId = 1; // Replace this with actual session ID in production

        // Initialize variables
        $proCount = 0;
        $completedproCount = 0;
        $projects = [];
        $projectz = [];

        // If supervisor ID exists, fetch data
        if ($supervisorId) {
            $proCount = $this->projects->countOngoingProjectsBySupervisorId($supervisorId);
            $completedproCount = $this->projects->countCompletedProjectsBySupervisorId($supervisorId);
            $projects = $this->projects->findOngoingProjects($supervisorId);
            $projectz = $this->projects->findCompletedProjects($supervisorId);
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
