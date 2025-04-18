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

    public function opensitevisit($land_id){
        header("Location: " . URLROOT . "Admin/Site_visit/" . $land_id);
        exit();
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
        // Redirect to the same page or another page
        header('Location: ' . URLROOT . '/admin/pending_approval');
    } else {
        echo "Visit not found!";
    }
}



private function sendEmail($email, $land_id, $date,$role)
    {
        // Create PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'rashipathinayaka@gmail.com'; // Your Gmail address
            $mail->Password = 'hlxx uucx rsdl jvyh'; // Your Gmail App password (not the regular password)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS encryption
            $mail->Port = 587; // SMTP port for TLS

            // Set from and to addresses
            $mail->setFrom('rashipathinayaka@gmail.com', 'Green Lease'); // Sender's email
            $mail->addAddress($email); // Receiver's email (Supervisor)

            // Set email format to HTML
            $mail->isHTML(true);
            $mail->Subject = "New Site Visit Assigned"; // Email subject
            $mail->Body = "
                Hello $role,<br><br>
                You have been assigned a new site visit.<br><br>
                <strong>Land ID:</strong> $land_id<br>
                <strong>Visit Date:</strong> $date<br><br>
                Please log in to your dashboard for more details.<br><br>
                Regards,<br>
                Green Lease Team
            "; // Email body content (HTML)

            // Send email
            if ($mail->send()) {
                echo "Email sent successfully to $email!";
            } else {
                throw new Exception("Email could not be sent.");
            }
        } catch (Exception $e) {
            // Log error to PHP error log
            error_log("Email error: {$mail->ErrorInfo}");
            echo "There was an issue sending the email: " . $e->getMessage();  // Optionally display error message in dev
        }
    }
}


