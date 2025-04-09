<?php

class Logout
{
    use Controller;

    public function index()
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: " . URLROOT . "/login");
        exit();
    }
}
