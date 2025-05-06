<?php
class Index extends Controller2 {

    public function __construct() {
        if (!isset($_SESSION['id'])) {
            redirect('login');
        }
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
            $this->applyForEvent($_POST['event_id']);
            return;
        }

        $userId = $_SESSION['id'];

        $eventModel = new Event;
        $events = $eventModel->getAvailableEventsForWorker($userId);

        $userModel = new User();
        $userData = $userModel->first(['id' => $userId]);

        $data = [
            'events' => $events,
            'notifications' => [],
            'sname' => $userData->full_name
        ];

        $this->view('worker/index', $data);
    }

    private function applyForEvent($event_id) {
        $worker_id = $_SESSION['id'];
        
        $workerEventModel = new WorkerEventModel();

        $existing = $workerEventModel->first([
            'worker_id' => $worker_id,
            'event_id' => $event_id
        ]);

        if ($existing) {
            $_SESSION['message'] = 'You have already applied for this event';
            $_SESSION['message_type'] = 'error';
            redirect('worker');
            return;
        }

        $result = $workerEventModel->insert([
            'worker_id' => $worker_id,
            'event_id' => $event_id,
            'status' => 'Pending'
        ]);

        if ($result) {
            $_SESSION['message'] = 'Successfully applied for the event';
            $_SESSION['message_type'] = 'success';

            $eventModel = new Event();
            $event = $eventModel->first(['id' => $event_id]);
            $projectId = $event ? $event->project_id : null;

            $projectModel = new Project();
            $project = $projectModel->first(['id' => $projectId]);
            
            if ($project) {
                $siteheadModel = new Sitehead();
                $sitehead = $siteheadModel->first(['land_id' => $project->land_id]);
                
                if ($sitehead) {
                    $userModel = new User();
                    $siteheadUser = $userModel->first(['id' => $sitehead->user_id]);
                    
                    if ($siteheadUser) {
                        $notificationModel = new Notification();
                        $notificationModel->create([
                            'user_id' => $siteheadUser->id,
                            'type' => 'worker_event_applied',
                            'message' => "A worker has applied for event: " . $event->event_name,
                        ]);
                    }
                }
            }
        } else {
            $_SESSION['message'] = 'Failed to apply for the event';
            $_SESSION['message_type'] = 'error';
        }

        redirect('worker');
    }
}
