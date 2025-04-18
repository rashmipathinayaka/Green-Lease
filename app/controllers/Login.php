<?php

class Login
{
    use Controller;

    public function index($a = '', $b = '', $c = '')
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userm = new User();
            $user = $userm->findUserByUsernameOrEmail($email);

            if ($user && $password == $user->password) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['id'] = $user->id;
                $_SESSION['name'] = $user->full_name;
                $_SESSION['email'] = $user->email;
                $_SESSION['role_id'] = $user->role_id;

                redirect('home');
                exit();
            } else {
                echo "Invalid username or password.";
                redirect('unauthorized');
                exit();
            }
        }

        $this->view('login');
    }
}
