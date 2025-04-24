<?php 
class Approve_land
{
    use Controller;
    private $project;
    private $siteheadmodel;

    public function __construct()
    {
        $this->project = new RProject;
        $this->siteheadmodel = new Sitehead;
    }

    public function index()
    {
        $showBigForm = false;
        $landInfo = null;
        $supinfo = null;
        $alertMessage = '';  // Initialize the alert message variable

        // $supervisor_id=$_SESSION['id'];
        $supervisor_id = '1';

        $land_id = $_POST['land_id'] ?? null;
        $exist = $this->project->checkLandIdExists($land_id);

        // Check if the project already exists
        if ($exist) {
            $alertMessage = 'A project for this land already exists';  // Set the alert message
      
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formdata = [
                'land_id' => $_POST['land_id'] ?? null,
                'crop_type' => $_POST['crop_type'] ?? null,
                'duration' => $_POST['duration'] ?? null,
                'profit' => $_POST['profit'] ?? null,
                'sitehead_id' => $_POST['sitehead'] ?? null,
                'status' => 'pending',
                'supervisor_id' => $supervisor_id,
                'description' => $_POST['description'] ?? null,
            ];

            // If only land_id is posted (first form)
            if (!isset($_POST['crop_type'])) {
                $landInfo = $this->project->getforminfo($formdata['land_id']);
                $supinfo = $this->project->getsupinfo($formdata['land_id']);
                $showBigForm = true;
            } else {
                // Full form submitted, initialize project
                if ($this->project->initializeproject($formdata)) {
                    $_SESSION['success_message'] = "Project initialized successfully!";
                    header('Location: ' . URLROOT . '/admin/initialize_project');
                    exit;
                }
            }
        }

        $sitehead = $this->siteheadmodel->getAllSiteheads($supervisor_id);

        // Pass the alert message to the view
        $this->view('Supervisor/Approve_land', [
            'showBigForm' => $showBigForm,
            'landInfo' => $landInfo,
            'supinfo' => $supinfo,
            'sitehead' => $sitehead,
            'alertMessage' => $alertMessage,  // Pass alert message
        ]);
    }
}
