<?php

class Contact
{
    use Controller;
    public function index($a = '', $b = '', $c = '')
    {
        $this->view('contact');
    }
}
