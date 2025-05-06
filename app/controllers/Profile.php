<?php 
class Profile
{
    use Controller;
    private $user;
    private $supervisor;
    private $sitehead;
private $worker;
private $buyer;

    public function __construct()
    {
        $this->user = new RUser;
        $this->supervisor = new RSupervisor;
        $this->sitehead = new RSitehead;
        $this->worker = new RWorker;
        $this->buyer= new RBuyer;
    }

    public function index($id = null)
    {
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
            } elseif (isset($_POST['worker_id'])) {
                $id = $_POST['worker_id'];
                $user = $this->worker->getWorkerbyid($id);
                $this->view('components/profile', ['user' => $user, 'user_type' => 'worker']);
                return;
            } elseif (isset($_POST['buyer_id'])) {
                $id = $_POST['buyer_id'];
                $user = $this->buyer->getBuyerbyid($id);
                $this->view('components/profile', ['user' => $user, 'user_type' => 'buyer']);
                return;
            } else {
                echo "User ID not provided.";
                return;
            }
        }

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
        $user = $this->worker->getWorkerbyid($id);
        if ($user) {
            $this->view('components/profile', ['user' => $user, 'user_type' => 'worker']);
            return;
        }
        $user = $this->buyer->getBuyerbyid($id);
        if ($user) {
            $this->view('components/profile', ['user' => $user, 'user_type' => 'buyer']);
            return;
        }

        echo "User not found.";
    }
}