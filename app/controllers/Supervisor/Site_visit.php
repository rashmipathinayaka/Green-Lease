<?php

/**
 * home class
 */
class Site_visit
{
	use Controller;
	private $sitevisit;

	public function __construct()
	{
		$this->sitevisit = new RSite_visit();
	}



	public function index()
{
	// $userid=$_SESSION['id'];
	$userid=32;
    $visitdata = $this->sitevisit->getAllSiteVisits($userid);


$visitdata1=$this->sitevisit->getAllapprovedSiteVisits($userid);

$data = [
	'visitdata' => $visitdata,
	'visitdata1' => $visitdata1
];


    $this->view('supervisor/site_visit', $data);
}





public function rescheduleVisit()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $visitId = $_POST['visit_id'];
        $landId = $_POST['land_id'];
        $date = $_POST['new_date'];
        $time = $_POST['new_time'];
        
        // Combine date and time
        $datetime = $date . ' ' . $time . ':00';
        
        // Update in database
        $success = $this->sitevisit->updateVisitSchedule($visitId, $datetime);
        
        if ($success) {
            // Redirect back with success message
            $_SESSION['message'] = 'Visit rescheduled successfully';
            header('Location: ' . URLROOT . '/Supervisor/Site_visit');
            exit;
        } else {
            // Handle error
            $_SESSION['error'] = 'Failed to reschedule visit';
            header('Location: ' . URLROOT . '/Supervisor/Site_visit');
            exit;
        }
    }
}


public function directapprove($id){

$this->sitevisit->insertapproval($id);


$this->view('supervisor/site_visit');



}



}