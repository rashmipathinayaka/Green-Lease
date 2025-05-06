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
        echo "User not found.";
    }

}

public function updateprofile()
{
    $id = $_POST['id'] ?? null; 
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
            header('Location: ' . URLROOT . "/Profile2/index/{$id}");





            exit;
        }
      
    }} else {
        $id = $_GET['id'] ?? null;
        header('Location: ' . URLROOT . '/profile2/index/' . $id);
        exit;
    }

}



public  function profilenavigation(){

    $id=$_SESSION['id'];

    header('Location: ' . URLROOT . '/profile2/index/' . $id);



}

public function updatepropic()


{
$userId = $_SESSION['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_pic'])) {
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'assets/Images/propics/';
        
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);  
        }
        
        $filename = time() . '_' . basename($_FILES['profile_pic']['name']);
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
            $this->user->updateProfilePicture($userId, $filename);
        }
    }
}


    header('Location: ' . URLROOT . '/profile2/index/' . $userId);
    exit;
    
}





}

