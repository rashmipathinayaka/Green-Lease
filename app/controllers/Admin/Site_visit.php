<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php'; // Adjust if needed

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
            $supervisorModel = new RSupervisor();
            $email = $supervisorModel->getEmailById($supervisor_id);

            // Send email to supervisor if email is found
            if ($email) {
                $this->sendEmailToSupervisor($email, $land_id, $date);
            }

            // Redirect after processing
            header('Location: ' . URLROOT . '/admin/pending_approval');
            exit;
        }

        // Get all supervisors for the form
        $supervisorModel = new RSupervisor();
        $supervisors = $supervisorModel->getAllSupervisors();

        // Pass data to the view
        $data = [
            'supervisors' => $supervisors,
            'land_id' => $land_id
        ];

        $this->view('admin/site_visit', $data);
    }

    private function sendEmailToSupervisor($email, $land_id, $date)
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
                Hello Supervisor,<br><br>
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
