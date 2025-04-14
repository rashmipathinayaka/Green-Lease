<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php'; // Adjust if needed

class Add_sitehead
{
    use Controller;
    private $sitehead;
    private $userModel;

    public function __construct()
    {
        $this->sitehead = new RSitehead;
        $this->userModel = new RUser;
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = $_POST['full_name'] ?? null;
            $zone = $_POST['land'] ;
            $email = $_POST['email'] ?? null;
            $contact_no = $_POST['contact_no'] ?? null;
            $status = $_POST['status'] ?? null;
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
            $this->userModel->insertsitehead($formData1);
            
            // Retrieve the user ID by NIC
            $user = $this->userModel->getUserIdByNic($nic);

            if ($user) {
                // Data for supervisor table
                $formData2 = [
                    'zone' => $zone,
                    'status' => $status,
                    'user_id' => $user, // foreign key
                ];

                // Insert into supervisor table
                $this->sitehead->insert($formData2);

                // Send an email with the plain password to the supervisor
                $this->sendEmailToSitehead($email, $full_name, $password);
            }
        }

        $this->view('admin/add_sitehead');
    }

    // Function to generate a random password
    private function generateRandomPassword($length = 12) {
        return bin2hex(random_bytes($length)); // Generate a random password
    }

    // Function to send the password to the supervisor via email
    private function sendEmailToSitehead($email, $full_name, $password)
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
            $mail->Subject = "Your Sitehead Account Password"; // Email subject
            $mail->Body = "
                Hello $full_name,<br><br>
                Your sitehead account has been created successfully.<br><br>
                <strong>Your Password:</strong> $password<br><br>
                Please log in to your dashboard using this password and change it as soon as possible.<br><br>
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
