<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php'; // Adjust if needed

/**
 * home class
 */
class Pending_approval
{
	use Controller;
    private $manageland;
    private $sitevisit;
    public function __construct()
    {
       $this-> manageland =new RLand();
       $this-> sitevisit =new Rsite_visit();
        

    }

	public function index()
	{

$visitdata1 = $this->sitevisit->getallapprovedvisits();


        $lands = $this->manageland->getpendinglands();
       
    


        $this->view('admin/pending_approval',['lands'=> $lands, 'visitdata1'=>$visitdata1]);
		
	}




public function getland($visit_id)
{
    // Get full visit info
    $visit = $this->sitevisit->getVisitById($visit_id);

    if ($visit) {
        $land_id = $visit->land_id;
        $supervisor_id = $visit->supervisor_id;
        $landowner_id = $visit->landowner_id;
        $date = $visit->date;

        // Get supervisor email
        $supervisorModel = new RSupervisor();
        $supervisor_email = $supervisorModel->getEmailById($supervisor_id);

        // Get landowner email
        $landownerModel = new RUser();
        $landowner_email = $landownerModel->getEmailById($landowner_id);

        // Send email to supervisor
        if ($supervisor_email) {
            $this->sendEmail($supervisor_email, $land_id, $date, 'Supervisor');
        }

        // Send email to landowner
        if ($landowner_email) {
            $this->sendEmail($landowner_email, $land_id, $date, 'Landowner');
        }

        echo "Emails sent successfully!";
        $this->sitevisit->emailupdate($visit_id); 
    } else {
        echo "Visit not found!";
    }
}

private function sendEmail($email, $land_id, $date, $role)
{
    $to = $email;
    $subject = "Scheduled Visit Notification";
    $message = "Dear $role,\n\nA site visit has been scheduled.\n\nLand ID: $land_id\nDate: $date\n\nThank you,\nGreen Lease Team";

    $headers = "From: rashipathinayaka@gmail.com"; // use your email

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent to $role ($email).<br>";
    } else {
        echo "Failed to send email to $role ($email).<br>";
    }
}

}