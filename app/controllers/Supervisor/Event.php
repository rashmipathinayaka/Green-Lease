<?php

class Event
{
    protected $EventModel;
    protected $Project;

    public function __construct()
    {
        $this->EventModel = new EventModel();      // Handles event-related DB operations
        $this->Project = new Project();  // Handles project-related DB operations
    }

    // Display event view page
    public function events()
    {
        $data = [];
        $this->view('supervisor/event', $data);
    }

    // Add new event to the database
    public function addEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Sanitize inputs
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

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
                'duration_hours' => intval($_POST['duration_hours']),
            ];

           

            // Check project ownership
            $project = $this->Project->getProjectById($data['project_id']);
            if ($project && $project->supervisor_id == 1) {  //if ($project && $project->supervisor_id == $_SESSION['id']) {

                if ($this->EventModel->addEvent($data)) {
                    $_SESSION['event_message'] = [
                        'message' => 'Event added successfully',
                        'class' => 'alert alert-success'
                    ];
                    redirect('supervisors/event');
                } else {
                    $_SESSION['event_message'] = [
                        'message' => 'Failed to add event',
                        'class' => 'alert alert-danger'
                    ];
                    $this->view('supervisor/event', $data);
                }

            } else {
                $_SESSION['event_message'] = [
                    'message' => 'Unauthorized to add event to this project',
                    'class' => 'alert alert-danger'
                ];
                redirect('supervisors/event');
            }

        } else {
            redirect('supervisors/event');
        }
    }
}
