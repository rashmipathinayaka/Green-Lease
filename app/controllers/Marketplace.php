<?php

class Marketplace{

    use Controller;

    public function index($a = '', $b = '' , $c = ''){
         // Ensure session_start() is called first
         if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Check if the user is logged in and is an admin
        if (!isset($_SESSION['id'])) { // Assuming 1 is the role ID for admin
            header("Location: " . URLROOT . "/unauthorized");
            exit();
        }

        $this->view('marketplace');
    }
}
