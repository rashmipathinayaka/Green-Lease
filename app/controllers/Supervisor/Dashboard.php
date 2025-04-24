<?php

class Dashboard  
{
    use Controller;
    private $projects;
    
    public function index()
{
    
    $this->projects = new Project();
    $supervisorId = 1; // Example supervisor ID, replace with actual session or dynamic value

    // Get data from the model
    $ongoingCount = $this->projects->countOngoingProjects($supervisorId);
    $completedCount =$this->projects->countcompletedProjects($supervisorId);
    $projects = $this->projects->getProjectsBySupervisor($supervisorId);

   
        $this->view('Supervisor/Dashboard', [
            'ongoingCount' => $ongoingCount,
        'completedCount' => $completedCount,
        'projects' => $projects
        ]);

    // Pass data to the view
    $data = [
        'ongoingCount' => $ongoingCount,
        'completedCount' => $completedCount,
        'projects' => $projects
    ];

    if ($supervisorId) {
        // Get land count for the logged-in user
        $proCount = $this->projects->countOngoingProjectsByUserId($supervisorId);
    } else {
        $proCount = 0; // Default value if user is not logged in
    }


    if ($supervisorId) {
        // Get land count for the logged-in user
        $proCount = $this->projects->countOngoingProjectsByUserId($supervisorId);
    } else {
        $proCount = 0; // Default value if user is not logged in
    }

    if ($supervisorId) {
        // Get land count for the logged-in user
        $completedproCount = $this->projects->countcompletedProjectsByUserId($supervisorId);
    } else {
        $completedproCount = 0; // Default value if user is not logged in
    }



    if ($supervisorId) {
        // Get land count for the logged-in user
        $completedproCount = $this->projects->countcompletedProjectsByUserId($supervisorId);
    } else {
        $completedproCount = 0; // Default value if user is not logged in
    }

    


    $projects = $this->projects->findOngoingprojects($supervisorId);
    $projectz = $this->projects->findCompletedprojects($supervisorId);
    


    $this->view('Supervisor/index', [ 'proCount' => $proCount, 'completedproCount'=>$completedproCount,
    
               'projects'=> $projects, 'projectz'=>$projectz, ]);


    
}

}
