<?php

class Project
{
    use Controller;

    public function index()
    {
        $this->view('components/project');
    }
}
