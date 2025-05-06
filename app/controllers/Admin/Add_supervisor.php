<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php'; 

class Add_supervisor
{
    use Controller;
    private $supervisor;
    private $userModel;
    private $zoneModel;

    public function __construct()
    {
        $this->supervisor = new RSupervisor;
        $this->userModel = new RUser;
        $this->zoneModel = new RZone;
    }

    public function index()
    {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = $_POST['full_name'] ?? null;
            $zone = $_POST['zone'] ?? null;
            $email = $_POST['email'] ?? null;
            $contact_no = $_POST['contact_no'] ?? null;
            $status = 'inactive';
            $nic = $_POST['nic'] ?? null;
            
            $password = $this->generateRandomPassword(8); 

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $formData1 = [
                'full_name' => $full_name,
                'email' => $email,
                'contact_no' => $contact_no,
                'nic' => $nic,
                'password' => $hashedPassword, 
            ];

            $this->userModel->insertsupervisor($formData1);
            
            $user = $this->userModel->getUserIdByNic($nic);

            if ($user) {
                
                $formData2 = [
                    'zone' => $zone,
                    'status' => $status,
                    'user_id' => $user, 
                ];

               if($this->supervisor->insert($formData2)){
               
               }
            
       
                $this->sendEmailToSupervisor($email, $full_name, $password);
                

            }
        }
$zones = $this->zoneModel->getAllZones(); 
        $this->view('admin/add_supervisor', ['zones' => $zones]);
    }

    private function generateRandomPassword($length = 12) {
        return bin2hex(random_bytes($length)); 
    }

    private function sendEmailToSupervisor($email, $full_name, $password)
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
            $mail->Subject = "Your Supervisor Account Password"; 
            $mail->Body = "
                Hello $full_name,<br><br>
                Your supervisor account has been created successfully.<br><br>
                <strong>Your Password:</strong> $password<br><br>
                Please log in to your dashboard using this password and change it as soon as possible.<br><br>
                Regards,<br>
                Green Lease Team
            "; // Email body content (HTML)

            // Send email
            if ($mail->send()) {
                // echo "Email sent successfully to $email!";
            } else {
                // throw new Exception("Email could not be sent.");
            }
        } catch (Exception $e) {
            // Log error to PHP error log
            // error_log("Email error: {$mail->ErrorInfo}");
            // echo "There was an issue sending the email: " . $e->getMessage();  // Optionally display error message in dev
        }
    }
}
