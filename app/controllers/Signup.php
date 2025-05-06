<?php

class Signup
{   
    use Controller;

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->register();
        } else {
            $this->view('signup');
        }
    }

    public function register()
    {
        $user = new User();

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
            'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT),
            'role_id' => $role_id,
            'full_name' => htmlspecialchars(trim($_POST['name'])),
            'contact_no' => htmlspecialchars(trim($_POST['contact'])),
            'nic' => htmlspecialchars(trim($_POST['nic']))
        ];

        if ($user->emailExists($userData['email'])) {
            $data = ['error' => 'Email already exists!'];
            $this->view('signup', $data);
            return;
        }

        $user->register($userData);

        header('Location: ' . URLROOT . '/login');
        exit();
    }
}