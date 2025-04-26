<?php
class ForgotPassword
{
    use Controller;

    public function index()
    {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $userModel = new User();
            $user = $userModel->first(['email' => $email]);
            if ($user) {
                $token = bin2hex(random_bytes(32));
                $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
                $userModel->update($user->id, [
                    'reset_token' => $token,
                    'reset_token_expiry' => $expiry
                ]);
                $resetLink = URLROOT . "/resetpassword?token=$token";
                // Use mail() for simplicity; replace with PHPMailer for production
                mail($email, "Password Reset", "Click here to reset your password: $resetLink");
            }
            $data['message'] = "If your email exists in our system, you will receive a reset link.";
        }
        $this->view('forgot_password', $data);
    }
} 