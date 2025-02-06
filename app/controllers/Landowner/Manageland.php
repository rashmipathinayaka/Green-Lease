<?php

class Manageland {
    use Controller;

    // Declare a class property for the Land model
    private $manageland;

    public function __construct() {
        // Initialize the Land model in the constructor
        $this->manageland = new Land();
    }

    public function index() {
       
        $lands = $this->manageland->findAll();
            
        $this->view('landowner/manageland', ['lands' => $lands]);
    }


    
    public function deleteland($id) {

        if ($this->manageland->delete($id)) {
              
 $lands = $this->manageland->findAll();
           $this->view('landowner/manageland', ['lands' => $lands]);
        } else {
            // If deletion fails, show a 404 page or an error message
            $this->view('_404');
        }
    }
    



    }
    



