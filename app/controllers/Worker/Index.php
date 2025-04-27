<?php
class Index {

    use Controller;

    public function __construct() {
        if (!isset($_SESSION['id'])) {
            redirect('login');
        }
    }

    public function index()
    {
        // Handle event application if POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
            $this->applyForEvent($_POST['event_id']);
            return;
        }

        $userId = $_SESSION['id'];

        // Get events
        $eventModel = new Event;
        $events = $eventModel->getAvailableEvents();

        // Get user data
        $userModel = new User();
        $userData = $userModel->first(['id' => $userId]);

        // Prepare data array
        $data = [
            'events' => $events,
            'notifications' => [],
            'sname' => $userData->full_name
        ];

        // Load the view with all data
        $this->view('worker/index', $data);
    }

    private function applyForEvent($event_id) {
        $worker_id = $_SESSION['id'];
        
        $workerEventModel = new WorkerEventModel();
        
        // Check if worker has already applied
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

        // Store the application
        $result = $workerEventModel->insert([
            'worker_id' => $worker_id,
            'event_id' => $event_id,
            'status' => 'Pending'
        ]);

        if ($result) {
            $_SESSION['message'] = 'Successfully applied for the event';
            $_SESSION['message_type'] = 'success';

            // --- Notification Logic ---
            // 1. Get the project_id from the event
            $eventModel = new Event();
            $event = $eventModel->first(['id' => $event_id]);
            $projectId = $event ? $event->project_id : null;

            // 2. Get the project details including land_id
            $projectModel = new Project();
            $project = $projectModel->first(['id' => $projectId]);
            
            if ($project) {
                // 3. Get the sitehead assigned to this land
                $siteheadModel = new Sitehead();
                $sitehead = $siteheadModel->first(['land_id' => $project->land_id]);
                
                if ($sitehead) {
                    // 4. Get the sitehead's user_id
                    $userModel = new User();
                    $siteheadUser = $userModel->first(['id' => $sitehead->user_id]);
                    
                    if ($siteheadUser) {
                        // 5. Insert notification for that user
                        $notificationModel = new Notification();
                        $notificationModel->create([
                            'user_id' => $siteheadUser->id,
                            'type' => 'worker_event_applied',
                            'message' => "A worker has applied for event: " . $event->event_name,
                            // 'link' => URLROOT . "/Sitehead/Event/details/$event_id"
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
