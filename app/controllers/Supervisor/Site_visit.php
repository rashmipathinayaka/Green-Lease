<?php

/**
 * home class
 */
class Site_visit
{
	use Controller;
	private $sitevisit;
    private $siteheadmodel;
private $project;



	public function __construct()
	{
		$this->sitevisit = new RSite_visit();
        $this->project=new RProject;
        $this->siteheadmodel=new RSitehead;
	}



	public function index()
{
	 $user_id=$_SESSION['id'];
	$userid=32;
    $visitdata = $this->sitevisit->getAllSiteVisits($userid);

    $sitehead = $this->siteheadmodel->getAllSiteheads($user_id);
$visitdata1=$this->sitevisit->getAllapprovedSiteVisits($userid);

$data = [
	'visitdata' => $visitdata,
	'visitdata1' => $visitdata1,
    'sitehead'=>$sitehead
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

public function initializeproject(){

$user_id=$_SESSION['id'];

$supervisor_id = $this->project->getsupervisoridbyuserid($user_id);


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



   if ($this->project->initializeproject($formdata)) {
                                header('Location: ' . URLROOT . '/Supervisor/site_visit');
                                exit;
                            }

}

}


public function rejectVisit(){
    // Check if reason and visit_id are provided via POST
    if (isset($_POST['reasons']) && isset($_POST['visit_id'])) {
        $reason = $_POST['reasons'];  
        $id = $_POST['visit_id'];     
    } else {
        // Handle error if any field is missing
        echo "Reason and Visit ID are required.";
        exit;
    }
echo $id;
    // Pass the id and reason to the rejectproject method
    $formdata = [
        'id' => $id,
        'reason' => $reason
    ];

    // Call the method to reject the visit along with the reason
    $this->project->rejectproject($formdata);

    // Redirect after processing
    header('Location: ' . URLROOT . '/Supervisor/site_visit');
    exit;
}


}