<?php

class App
{
    private $controller = 'home';
    private $method = 'index';

    private function splitURL()
    {
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL,"/"));
        return($URL);
    }
    
    public function loadController()
    {
        $URL = $this->splitURL();

        // Build controller path by checking if the URL contains folder segments
        $controllerPath = "../app/controllers/";
        foreach ($URL as $key => $segment) {
            if(is_dir($controllerPath . ucfirst($segment))) {
                // If the segment is a folder, go into it
                $controllerPath .= ucfirst($segment) . "/";
                unset($URL[$key]);
            } else {
                // Once we hit something that is not a folder, it should be the controller file
                $controllerPath .= ucfirst($segment) . ".php";
                $this->controller = ucfirst($segment);  // Set controller
                unset($URL[$key]);
                break;  // Exit the loop as we found the controller
            }
        }

        // If the controller file exists, require it
        if(file_exists($controllerPath))
        {
            require $controllerPath;
        } 
        else
        {
            // Load the 404 controller if the file doesn't exist
            require "../app/controllers/_404.php";
            $this->controller = "_404";
        }

        // Instantiate the controller
        $controller = new $this->controller;

        // Select the method to execute
		//methena okkoma [1] thibune
        if(!empty($URL[2]))
        {
            if(method_exists($controller, $URL[2]))
            {
                $this->method = $URL[2];
                unset($URL[2]);
            }
        }

        // Execute the method and pass remaining URL parameters as arguments
        call_user_func_array([$controller, $this->method], $URL);
    }
}