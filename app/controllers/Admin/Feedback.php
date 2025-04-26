<?php 
class Feedback{

use Controller;


    private $feedbackmodel;


    public function __construct() {
        $this->feedbackmodel = new RFeedback();;
    }

 
public function index(){




$unsolved=$this->feedbackmodel->getunsolvedFeedbacks();
$solved=$this->feedbackmodel->getsolvedFeedbacks();





$data=[
    'unsolved'=>$unsolved,
    'solved'=>$solved,
];




$this->view('admin/Feedback',$data);



}




// public function markSolved() {

//     // $user_id = $_SESSION['user_id'];
//     $user_id = 1;
//     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//         $feedbackId = $_POST['feedback_id'];
//         $this->feedbackmodel->markAsSolved($feedbackId,$user_id);
//         header('Location: ' . URLROOT . '/admin/Feedback/index');
//         exit;
//     }


// }



public function markSolved() {
    
    // $user_id = $_SESSION['user_id'];
    $user_id = 1;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $feedbackId = $_POST['feedback_id'] ?? null;
        $remark = $_POST['remark'] ?? '';

        // Now you can use $feedbackId and $remark however you want!
        
        // Example: Save remark to database
        $this->feedbackmodel->markAsSolved($feedbackId, $user_id,$remark);

        // Redirect or flash message
        header('Location: ' . URLROOT . '/admin/Feedback');
        exit();
    } else {
        die('Invalid Request');
    }
}


public function deleteFeedback() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $feedbackId = $_POST['feedback_id'];
        $this->feedbackmodel->deleteFeedback($feedbackId);
        header('Location: ' . URLROOT . '/admin/Feedback/index');
        exit;
    }

}





}