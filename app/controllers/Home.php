<?php

class Home
{
    use Controller;

    public function index($a = '', $b = '', $c = '')
    {
        $this->view('home');
    }
}
