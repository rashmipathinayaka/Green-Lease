<?php

class Site_visit
{
    use Controller;

    public function index($land_id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supervisor_id = $_POST['supervisor_id'] ?? null;
            $date = $_POST['date'] ?? null;
            $land_id = $_POST['land_id'];

            $formdata = [
                'land_id' => $land_id,
                'supervisor_id' => $supervisor_id,
                'date' => $date
            ];

            // Insert site visit into database
            $sitevisit = new Rsite_visit();
            $sitevisit->insert($formdata);


            // Get supervisor email
            

            // Redirect after processing
            header('Location: ' . URLROOT . '/admin/pending_approval');
            exit;
        }

        $supervisorModel = new RSupervisor();
        // Get all supervisors for the form
        $landzone = $supervisorModel->getlandzone($land_id);
        $procount = $_GET['procount'] ?? 5;

        $supervisors = $supervisorModel->getAllSupervisorslessthanmaxcount($procount, $landzone);
        // Pass data to the view
        $data = [
            'supervisors' => $supervisors,
            'land_id' => $land_id,
            'procount'=>$procount
        ];

        $this->view('admin/site_visit', $data);
    }









}
