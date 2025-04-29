<?php

class Login
{
    use Controller;

    public function index($a = '', $b = '', $c = '')
    {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userm = new User();
            $user = $userm->findUserByUsernameOrEmail($email);

            if ($user) {
                // Debug output
                error_log("User found: " . $user->email);
                error_log("Stored password hash: " . $user->password);
                error_log("Password verification result: " . (password_verify($password, $user->password) ? "true" : "false"));
            } else {
                error_log("No user found with email: " . $email);
            }

            if ($user && password_verify($password, $user->password)) {
                $auth = Auth::getInstance();
                $auth->login($user);

                // Redirect based on role
                switch ($user->role_id) {
                    case 1: // Admin
                        redirect('admin/Index');
                        break;
                    case 2: // Supervisor
                        redirect('supervisor/dashboard');
                        break;
                    case 3: // Sitehead
                        redirect('sitehead/Index');
                        break;
                    case 4: // Landowner
                        redirect('landowner/Index');
                        break;
                    case 5: // Buyer
                        redirect('buyer/Index');
                        break;
                    case 6: // Worker
                        redirect('worker/Index');
                        break;
                    default:
                        redirect('home');
                }
                exit();
            } else {
                $data['error'] = "Email or password is incorrect.";
            }
        }

        $this->view('login', $data);
    }
}