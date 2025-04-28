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
            // 'email' => $_POST['email'],
            'contact_no' => $_POST['contact_no'],
            'nic' => $_POST['nic'],
            'id' => $_POST['id']
        ];

        if ($this->user->validate($data)) {
            $this->user->updateprofile($data, $id);
            // header('Location: ' . URLROOT . "/Components/Profile2/index/{$id}");
            header('Location: ' . URLROOT . '/Components/profile2/index/' . $id);



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

public function updatepropic()
// {
//     $userId = $_SESSION['id'];

//     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_pic'])) {
//         if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
//             $uploadDir = 'assets/Images/';
//             $filename = time() . '_' . basename($_FILES['profile_pic']['name']);
//             $targetFile = $uploadDir . $filename;

//             if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
//                 $this->user->updateProfilePicture($userId, $filename);
//             }
//         }
//     }

//     // Redirect back to profile page
//     header('Location: ' . URLROOT . '/Components/profile2/index/' . $userId);
//     exit;
// }

{
$userId = $_SESSION['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_pic'])) {
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        // Change the upload directory to 'propics' inside 'assets/Images'
        $uploadDir = 'assets/Images/propics/';
        
        // Ensure the 'propics' folder exists or create it if not
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);  // Creates the 'propics' folder if it doesn't exist
        }
        
        // Generate a unique filename for the uploaded file
        $filename = time() . '_' . basename($_FILES['profile_pic']['name']);
        $targetFile = $uploadDir . $filename;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
            // Update the profile picture path in the database
            $this->user->updateProfilePicture($userId, $filename);
        }
    }
}


//  Redirect back to profile page
    header('Location: ' . URLROOT . '/Components/profile2/index/' . $userId);
    exit;
    
}





}

