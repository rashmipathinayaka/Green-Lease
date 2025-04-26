<?php
class ResetPassword
{
    use Controller;

    public function index()
    {
        $data = [];
        $token = $_GET['token'] ?? '';
        $userModel = new User();
        $user = $userModel->first(['reset_token' => $token]);
        if (!$user || strtotime($user->reset_token_expiry) < time()) {
            $data['error'] = "Invalid or expired token.";
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $newPassword = $_POST['password'];
            $userModel->update($user->id, [
                'password' => $newPassword,
                'reset_token' => null,
                'reset_token_expiry' => null
            ]);
            $data['message'] = "Password reset successful! You can now <a href='" . URLROOT . "/login'>login</a>.";
        }
        $this->view('reset_password', $data);
    }
} 