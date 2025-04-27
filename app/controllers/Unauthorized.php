<?php

class Unauthorized
{
    use Controller;

    public function index()
    {
        $this->view('unauthorized');
    }
}
