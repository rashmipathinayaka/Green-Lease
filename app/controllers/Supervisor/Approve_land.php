<?php
class Approve_land {
    use Controller;
    private $project;
    
    public function __construct() {
        $this->project = new RProject;
    }
    
    public function index() {
        $showBigForm = false;
        $landInfo = null;
        $supinfo = null;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formdata = [
                'land_id' => $_POST['land_id'] ?? null,
                'crop_type' => $_POST['crop_type'] ?? null,
                'duration' => $_POST['duration'] ?? null,
                'supervisor_id' => $_POST['supervisor_id'] ?? null,
                'status' => 'ongoing',
                'start_date' => date('Y-m-d H:i:s'),
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
    
        $this->view('Supervisor/Approve_land', [
            'showBigForm' => $showBigForm,
            'landInfo' => $landInfo,
            'supinfo' => $supinfo,
        ]);
    }
    
    
}