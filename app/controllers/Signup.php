<?php

class Signup
{   
    use Controller;
    public function index($a = '', $b = '', $c = '')
    {
        $this->view('signup');
    }

    public function register()
    {
        $user = new User();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $role_id = 0;

            if ($_POST['role'] === 'buyer') {
                $role_id = 5;
            } elseif ($_POST['role'] === 'landowner') {
                $role_id = 4;
            } elseif ($_POST['role'] === 'worker') {
                $role_id = 6;
            }

            $userData = [
                'email' => filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL),
                'password' => htmlspecialchars(trim($_POST['password'])),
                'role_id' => $role_id,
                'full_name' => htmlspecialchars(trim($_POST['name'])),
                'contact_number' => htmlspecialchars(trim($_POST['contact'])),
                'nic' => htmlspecialchars(trim($_POST['nic']))
            ];

            // Check if email already exists
            if ($user->emailExists($userData['email'])) {
                echo "<h1 style=\"color: red;\">Error: Email already exists!</h1>";
                return;
            }

            // Hash the password
            $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);

            // Register user
            $user->register($userData);

            redirect('login');

        } else {
            $this->view('signup');
        }
    }
}
