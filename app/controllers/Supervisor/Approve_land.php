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
        $alertMessage = '';

        // $user_id=$_SESSION['id'];
        $user_id = '45'; 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $land_id = $_POST['land_id'] ?? null;

            if (!$land_id) {
                $alertMessage = 'Land ID is required.';
            } else {
                $exist = $this->project->checkLandIdExists($land_id);
                if ($exist) {
                    $alertMessage = 'A project for this land already exists.';
                } else {
                    $supervisor_id = $this->project->getsupervisoridbyuserid($user_id);

                    $assigned = $this->project->checksupervisorOfVisit($land_id, $supervisor_id);
                    if (!$assigned) {
                        $alertMessage = 'This land is not assigned to you. Please check again.';
                    } else {
                        // Passed all checks
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

                        if (!isset($_POST['crop_type'])) {
                            // Only land_id submitted: Show the big form
                            $landInfo = $this->project->getforminfo($formdata['land_id']);
                            $supinfo = $this->project->getsupinfo($formdata['land_id']);
                            $showBigForm = true;
                        } else {
                            // Full form submitted: Initialize the project
                            if ($this->project->initializeproject($formdata)) {
                                $_SESSION['success_message'] = "Project initialized successfully!";
                                header('Location: ' . URLROOT . '/admin/initialize_project');
                                exit;
                            }
                        }
                    }
                }
            }
        }

        $sitehead = $this->siteheadmodel->getSiteheadsBySupervisorUserId($user_id); // <-- use $user_id or $supervisor_id as needed

        $this->view('Supervisor/Approve_land', [
            'showBigForm' => $showBigForm,
            'landInfo' => $landInfo,
            'supinfo' => $supinfo,
            'sitehead' => $sitehead,
            'alertMessage' => $alertMessage,
        ]);
    }
}
