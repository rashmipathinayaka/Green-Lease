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








public function markSolved() {
    
     $user_id = $_SESSION['user_id'];
   
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $feedbackId = $_POST['feedback_id'] ?? null;
        $remark = $_POST['remark'] ?? '';

       
        $this->feedbackmodel->markAsSolved($feedbackId, $user_id,$remark);

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