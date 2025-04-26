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

        $eventModel = new Event; // Assuming your model is named Event.php
        $events = $eventModel->getAvailableEvents();

        $this->view('worker/index', [
            'events' => $events
        ]);
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
        } else {
            $_SESSION['message'] = 'Failed to apply for the event';
            $_SESSION['message_type'] = 'error';
        }

        redirect('worker');
    }
}
