<?php

class Manageland {
    use Controller;

    private $manageland;
    private $project;

    public function __construct() {
        $this->manageland = new RLand();
        $this->project = new RProject();
    }

    public function index() {
    
     $userId = $_SESSION['id'];
   
        $lands = $this->manageland->findlandsbyuserid($userId);







            
        $this->view('landowner/manageland', ['lands' => $lands]);
    }


    
    public function deleteland($id) {

        if ($this->manageland->delete($id)) {
              
 $lands = $this->manageland->findAll();
           $this->view('landowner/manageland', ['lands' => $lands]);
        } else {
            $this->view('_404');
        }
    }
    



    }
    



