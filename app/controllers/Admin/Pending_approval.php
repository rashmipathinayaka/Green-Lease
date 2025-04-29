<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php'; 

class Pending_approval
{
    use Controller;
    private $manageland;
    private $sitevisit;
    private $projects;



    public function __construct()
    {
        $this->manageland = new RLand();
        $this->sitevisit = new Rsite_visit();
        $this->projects = new RProject();
    }

    public function index()
    {

        $visitdata1 = $this->sitevisit->getallapprovedvisits();


        $lands = $this->manageland->getpendinglands();

        //adminge final approve eka gann tyena lands
        $project = $this->projects->getpendingprojects();



        $this->view('admin/pending_approval', ['lands' => $lands, 'visitdata1' => $visitdata1, 'project' => $project]);
    }


    public function opensitevisit($id)
    {
        echo $id;
        $land_id = $id;
        header("Location: " . URLROOT . "/admin/site_visit/index/{$land_id}");
    }


public function approveproject($id){

$this->projects->approveproject($id);
    header('Location: ' . URLROOT . '/admin/pending_approval');


}

public function rejectland($id){

    if($this->manageland->rejectland($id)){
       
    }

}





    public function getland($visit_id)
    {
        $visit = $this->sitevisit->getVisitById($visit_id);

        if ($visit) {
            $land_id = $visit->land_id;
            $supervisor_id = $visit->supervisor_id;
            $landowner_id = $visit->landowner_id;
            $re_date = $visit->re_date;

            $supervisorModel = new RSupervisor();
            $supervisor_email = $supervisorModel->getEmailById($supervisor_id);

            $landownerModel = new RUser();
            $landowner_email = $landownerModel->getEmailById($landowner_id);

            if ($supervisor_email) {
                $this->sendEmail($supervisor_email, $land_id, $re_date, 'Supervisor');
            }

            if ($landowner_email) {
                $this->sendEmail($landowner_email, $land_id, $re_date, 'Landowner');
            }

            echo "Emails sent successfully!";
            $this->sitevisit->emailupdate($visit_id);
            header('Location: ' . URLROOT . '/admin/pending_approval');
        } else {
            echo "Visit not found!";
        }
    }



    private function sendEmail($email, $land_id, $re_date, $role)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'rashipathinayaka@gmail.com'; 
            $mail->Password = 'bzpg bosn cfuf jabn'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 587; 

            $mail->setFrom('rashipathinayaka@gmail.com', 'Green Lease'); 
            $mail->addAddress($email); 

            $mail->isHTML(true);
            $mail->Subject = "New Site Visit Assigned"; 
            $mail->Body = "
                Hello $role,<br><br>
                You have been assigned a new site visit.<br><br>
                <strong>Land ID:</strong> $land_id<br>
                <strong>Visit Date:</strong> $re_date<br><br>
                
                <br><br>
                Regards,<br>
                Green Lease Team
            "; 

            
            if ($mail->send()) {
                echo "Email sent successfully to $email!";
            } else {
                throw new Exception("Email could not be sent.");
            }
        } catch (Exception $e) {
           
            error_log("Email error: {$mail->ErrorInfo}");
            echo "There was an issue sending the email: " . $e->getMessage();  
        }
    }
}
