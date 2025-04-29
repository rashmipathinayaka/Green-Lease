<?php

class Site_visit
{
    use Controller;

    public function index($land_id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supervisor_id = $_POST['supervisor_id'] ?? null;
            $from_date = $_POST['from_date'] ?? null;
            $to_date = $_POST['to_date'] ?? null;

            $land_id = $_POST['land_id'];

            $formdata = [
                'land_id' => $land_id,
                'supervisor_id' => $supervisor_id,
                
            ];




            $sitevisit = new Rsite_visit();
            $sitevisit->insertsupervisor($formdata);


           
            

            
            header('Location: ' . URLROOT . '/admin/pending_approval');
            exit;
        }

        $supervisorModel = new RSupervisor();
        $landzone = $supervisorModel->getlandzone($land_id);
        $procount = $_GET['procount'] ?? 5;

        $supervisors = $supervisorModel->getAllSupervisorslessthanmaxcount($procount, $landzone);

        $sitevisit= new Rsite_visit();
$daterange=$sitevisit->getdaterange($land_id);


        $data = [
            'supervisors' => $supervisors,
            'land_id' => $land_id,
            'procount'=>$procount,
           'from_date' => $daterange['from_date'] ?? null,
    'to_date' => $daterange['to_date'] ?? null,
        ];

        $this->view('admin/site_visit', $data);
    }









}
