<?php

class Dashboard extends Controller
{
   
    public function index()
{
    
    $projectModel = new Project();
    $supervisorId = 1; // Example supervisor ID, replace with actual session or dynamic value

    // Get data from the model
    $ongoingCount = $projectModel->countOngoingProjects($supervisorId);
    $completedCount = $projectModel->countcompletedProjects($supervisorId);
    $projects = $projectModel->getProjectsBySupervisor($supervisorId);

   

    // Pass data to the view
    $data = [
        'ongoingCount' => $ongoingCount,
        'completedCount' => $completedCount,
        'projects' => $projects
    ];

    extract($data); // Make $ongoingCount, $completedCount, $projects available in the view
    require_once '../app/views/supervisor/index.view.php';
}

}
