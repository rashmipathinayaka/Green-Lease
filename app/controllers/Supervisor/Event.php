<?php
class Event {
    private $db;
    private $projectModel;
    private $eventModel;

    public function __construct() {
        
        // Initialize Project model
        $this->eventModel = new Event();      // Initialize Event model
    }

    // Display events page
    public function events() {
        $data = [];
        $this->view('supervisor/event', $data);
    }

    // Add a new event
    public function addEvent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            
            // Create data array
            $data = [
                'project_id' => trim($_POST['project_id']),
                'event_name' => trim($_POST['event_name']),
                'date' => trim($_POST['date']),
                'time' => trim($_POST['time']),
                'location' => trim($_POST['location']),
                'workers_required' => intval($_POST['workers_required']),
                'payment_per_worker' => floatval($_POST['payment_per_worker']),
                'duration_years' => intval($_POST['duration_years']),
                'duration_months' => intval($_POST['duration_months']),
                'duration_days' => intval($_POST['duration_days']),
                'duration_hours' => intval($_POST['duration_hours'])
            ];
            
            // Calculate end date based on duration
            $endDate = new DateTime($data['date']);
            $endDate->modify("+{$data['duration_years']} years");
            $endDate->modify("+{$data['duration_months']} months");
            $endDate->modify("+{$data['duration_days']} days");
            $endDate->modify("+{$data['duration_hours']} hours");
            $data['end_date'] = $endDate->format('Y-m-d');
            
            // Verify the project belongs to the logged-in supervisor
            $project = $this->projectModel->getProjectById($data['project_id']);
            if ($project && $project->supervisor_id == $_SESSION['user_id']) {
                // Add event to database
                if ($this->eventModel->addEvent($data)) {
                    // Store the success message in session
                    $_SESSION['event_message'] = [
                        'message' => 'Event added successfully',
                        'class'   => 'alert alert-success'
                    ];
                    redirect('supervisors/event');
                } else {
                    // Store the error message in session
                    $_SESSION['event_message'] = [
                        'message' => 'Something went wrong',
                        'class'   => 'alert alert-danger'
                    ];
                    $this->view('supervisor/event', $data);
                }
            } else {
                // Unauthorized access
                $_SESSION['event_message'] = [
                    'message' => 'Unauthorized access',
                    'class'   => 'alert alert-danger'
                ];
                redirect('supervisors/event');
            }
        } else {
            // Redirect if not POST request
            redirect('supervisors/event');
        }
    }
}
