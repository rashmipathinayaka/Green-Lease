<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php'; // Adjust if needed

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
            
            // Generate a random plain password for the supervisor
            $password = $this->generateRandomPassword(8); // Password length of 12

            // User data for user table (storing the plain password here)
            $formData1 = [
                'full_name' => $full_name,
                'email' => $email,
                'contact_no' => $contact_no,
                'nic' => $nic,
                'password' => $password, // Storing the plain password directly
            ];

            // Insert into user table and get the user ID
            $this->userModel->insertsupervisor($formData1);
            
            // Retrieve the user ID by NIC
            $user = $this->userModel->getUserIdByNic($nic);

            if ($user) {
                
                $formData2 = [
                    'zone' => $zone,
                    'status' => $status,
                    'user_id' => $user, 
                ];

               //supervisor table ekta data insert karanna
               if($this->supervisor->insert($formData2)){
               
               }
            
       

                // Send an email with the plain password to the supervisor
                $this->sendEmailToSupervisor($email, $full_name, $password);
                

            }
        }
$zones = $this->zoneModel->getAllZones(); // Fetch all zones for the dropdown
        $this->view('admin/add_supervisor', ['zones' => $zones]);
    }

    // Function to generate a random password
    private function generateRandomPassword($length = 12) {
        return bin2hex(random_bytes($length)); // Generate a random password
    }

    // Function to send the password to the supervisor via email
    private function sendEmailToSupervisor($email, $full_name, $password)
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
            $mail->Subject = "Your Supervisor Account Password"; // Email subject
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
