<?php

class Index
{
    use Controller;

    public function index()
    {
        // session_start(); // REMOVE this line

        // Check if user is logged in
        if (!isset($_SESSION['id'])) {
            header('Location: ' . URLROOT . '/login');
            exit;
        }

        // Check if user is a sitehead (role_id = 3)
        if ($_SESSION['role_id'] != 2) {
            // Redirect to their own dashboard or show error
            header('Location: ' . URLROOT . '/unauthorized');
            exit;
        }

        $this->view('supervisor/index');
    }
}