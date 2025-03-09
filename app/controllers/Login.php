<?php

class Login
{
    use Controller;

    public function index($a = '', $b = '', $c = '')
    {
        $this->view('login');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userm = new User();

            $user = $userm->findUserByUsernameOrEmail($email);

            if ($user && password_verify($password, $user->password)) {



                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }


                $_SESSION['id'] = $user->id;
                $_SESSION['name'] = $user->full_name;
                $_SESSION['email'] = $user->email;
                $_SESSION['role_id'] = $user->role_id;

                if (1) {
                    redirect('home');
                } else {
                    redirect('unauthorized');
                }

                exit();
            } else {

                echo "Invalid username or password.";
                redirect('unauthorized');
            }
        }

        $this->view('login');
    }

    // public function logout() {
    //     if (!isset($_SESSION['user_id'])) {
    //         http_response_code(401); 
    //         echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    //         return;
    //     }

    //     $_SESSION = array();
    //     session_destroy();


    //     http_response_code(200); 
    //     echo json_encode(['status' => 'success', 'message' => 'Logged out successfully']);
    // }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: " . ROOT . "/login");
        exit();
    }


}
