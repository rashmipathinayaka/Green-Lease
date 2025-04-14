<?php 
class Profile
{
    use Controller;
    private $user;
    private $supervisor;
    private $sitehead;

    public function __construct()
    {
        $this->user = new RUser;
        $this->supervisor = new RSupervisor;
        $this->sitehead = new RSitehead;
    }

    public function index($id = null)
    {
        // If no ID is provided in the URL, check if it's coming from a form submission
        if (!$id) {
            if (isset($_POST['supervisor_id'])) {
                $id = $_POST['supervisor_id'];
                $user = $this->supervisor->getSupervisorbyid($id);
                $this->view('components/profile', ['user' => $user, 'user_type' => 'supervisor']);
                return;
            } elseif (isset($_POST['sitehead_id'])) {
                $id = $_POST['sitehead_id'];
                $user = $this->sitehead->getSiteheadbyid($id);
                $this->view('components/profile', ['user' => $user, 'user_type' => 'sitehead']);
                return;
            } else {
                echo "User ID not provided.";
                return;
            }
        }

        // If ID is provided in the URL, try both models
        $user = $this->sitehead->getSiteheadbyid($id);
        if ($user) {
            $this->view('components/profile', ['user' => $user, 'user_type' => 'sitehead']);
            return;
        }

        $user = $this->supervisor->getSupervisorbyid($id);
        if ($user) {
            $this->view('components/profile', ['user' => $user, 'user_type' => 'supervisor']);
            return;
        }

        echo "User not found.";
    }
}