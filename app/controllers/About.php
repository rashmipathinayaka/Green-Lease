<?php

class About
{
    use Controller;
    public function index($a = '', $b = '', $c = '')
    {
        $this->view('about');
    }
}
