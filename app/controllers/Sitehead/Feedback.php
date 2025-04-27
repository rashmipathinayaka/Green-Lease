<?php
class Feedback
{

    use Controller;


    private $feedbackmodel;


    public function __construct()
    {
        $this->feedbackmodel = new RFeedback();;
    }


    public function index()
    {

        $unsolved = $this->feedbackmodel->getunsolvedFeedbacks();
        $solved = $this->feedbackmodel->getsolvedFeedbacks();

        $userId = $_SESSION['id'];

        $sh = new Sitehead();
        $siteheadData = $sh->first(['user_id' => $userId]);
        $issueModel = new Issue();
        $issues = $issueModel->where(['sitehead_id' => $siteheadData->id]);

        $data = [
            'unsolved' => $unsolved,
            'solved' => $solved,
            'Issues' => $issues
        ];


        $this->view('sitehead/Feedback', $data);
    }


    public function markSolved()
    {

        // $user_id = $_SESSION['user_id'];
        $user_id = 1;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $feedbackId = $_POST['feedback_id'];
            $this->feedbackmodel->markAsSolved($feedbackId, $user_id);
            header('Location: ' . URLROOT . '/sitehead/Feedback/index');
            exit;
        }
    }


    public function deleteFeedback()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $feedbackId = $_POST['feedback_id'];
            $this->feedbackmodel->deleteFeedback($feedbackId);
            header('Location: ' . URLROOT . '/sitehead/Feedback/index');
            exit;
        }
    }
}
