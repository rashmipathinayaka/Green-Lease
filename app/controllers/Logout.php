<?php

class Logout
{
    use Controller;

    public function index()
    {
        $auth = Auth::getInstance();
        $auth->logout();
        redirect('login');
    }
}
