<?php
class Profile2{

use Controller;

    private $user;

public function __construct() {
    $this->user = new RUser;
}


public function index($id)
{
    $user = $this->user->getprofilebyid($id);
    if ($user) {
        $this->view('components/profile2', ['user' => $user]);
    } else {
        // Handle user not found case
        echo "User not found.";
    }

}

public function updateprofile()
{
    $id = $_POST['id'] ?? null; // Get the user ID from the POST data
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['action'] === 'save'){      
              $data = [
            'full_name' => $_POST['full_name'],
            'email' => $_POST['email'],
            'contact_no' => $_POST['contact_no'],
            'nic' => $_POST['nic'],
            'id' => $_POST['id']
        ];

        if ($this->user->validate($data)) {
            $this->user->updateprofile($data, $id);
            header('Location: ' . URLROOT . "/Components/Profile2/index/{$id}");
// $this->view('components/profile2', $id);


            exit;
        }
        // } else {
        //     // Handle validation errors
        //     $errors = $this->user->errors;
        //     $this->view('components/profile2', ['errors' => $errors, 'user' => $data]);
        // }
    }} else {
        // Handle GET request or other methods
        $id = $_GET['id'] ?? null;
        header('Location: ' . URLROOT . '/Components/profile2/index/' . $id);
        exit;
    }

}



public  function profilenavigation(){

    $id=$_SESSION['id'];

    header('Location: ' . URLROOT . '/Components/profile2/index/' . $id);



}










}