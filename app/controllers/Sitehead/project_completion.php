<?php
class project_completion
{
    use Controller;
    private $projectmodel;


    public function __construct()
    {

        $this->projectmodel = new RProject_completion();
    }


    public function index()
    {

        // $user_id=$_SESSION['id'];
        $user_id = 1;
        $proinfo = $this->projectmodel->getproinfobysiteheadid($user_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'profit_gained' => $_POST['profit_gained'],
                'remaining_harvest' => $_POST['remaining_harvest'],
                'description' => $_POST['special_notes'],
                'mark_complete' => $_POST['mark_complete'] ? 1 : 0,
                'project_id' => $_POST['project_id']
            ];
            

            echo $data['mark_complete'];
            if ($data['mark_complete']) {
                $this->projectmodel->markProjectAsComplete($data);
                header('Location: ' . URLROOT . '/sitehead/index');
                exit;
            } else {
                // Handle the case where the checkbox is not checked
                // You can show an error message or redirect as needed
                echo "Please check the box to mark the project as complete.";
            }
        }








        $this->view('sitehead/project_completion', ['proinfo' => $proinfo]);
    }
}
