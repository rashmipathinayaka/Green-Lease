<?php
class Site_visit
{
    use Controller;

    public function index($land_id=null)
    {
       

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supervisor_id = $_POST['supervisor_id'] ?? null; 
            $date = $_POST['date'] ?? null;  
            $land_id = $_POST['land_id'] ?? $land_id;


            $formdata = [
                'land_id' => $land_id,
                'supervisor_id' => $supervisor_id,
                'date' => $date
            ];

            $sitevisit = new Rsite_visit();
            $sitevisit->insert($formdata);
            header('Location: ' . URLROOT . '/admin/pending_approval');
            

            $supervisorModel = new RSupervisor(); 
            $supervisors = $supervisorModel->getAllSupervisors();

           

        } else {
            // Get the list of supervisors for the initial page load
            $supervisorModel = new RSupervisor(); 
            $supervisors = $supervisorModel->getAllSupervisors();

            // Pass the supervisors to the view
            $data = [
                'supervisors' => $supervisors,
                'land_id' => $land_id 
            ];
        }

        // Render the site visit page with the data
        $this->view('admin/site_visit', $data);
    }
}
