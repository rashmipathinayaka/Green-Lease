<?php
// filepath: c:\xampp\htdocs\Green-Lease\app\controllers\EventsController.php
<?php

class EventsController extends Controller {
    private $eventModel;

    public function __construct() {
        $this->eventModel = $this->model('EventModel');
    }

    // Method to handle adding a new event
    public function addEvent() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'project_id' => trim($_POST['project_id']),
                'name' => trim($_POST['event_name']),
                'date' => trim($_POST['event_date']),
                'time' => trim($_POST['event_time']),
                'location' => trim($_POST['event_location']),
                'worker' => trim($_POST['event_worker']),
                'icon' => trim($_POST['event_icon']),
            ];

            // Add event to the database
            if ($this->eventModel->addEvent($data)) {
                // Redirect to the events page
                header('Location: ' . URLROOT . '/event');
            } else {
                die('Something went wrong');
            }
        } else {
            // Load the events page
            $this->view('supervisor/event');
        }
    }
}