<?php

class App
{
    public function __construct()
    {
        // Initialize router with base URL
        Router::init(URLROOT);
    }
    
    public function loadController()
    {
        // Get the URL from GET parameters
        $url = $_GET['url'] ?? 'home';
        
        // Route the request
        Router::route($url);
    }
}