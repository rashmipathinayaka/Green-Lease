<?php
class Event
{
    use Controller;

    private $project;
    private $eventModel;

    public function __construct()
    {
        // Initialize the Project and EventModel models in the constructor
        $this->project = new Project;
        $this->eventModel = new modelEvent;
    }

    public function index()
    {
        // Get supervisor ID from session (using 1 for testing)
        $supervisorId = $_SESSION['id'] ?? 1;

        // Get all projects for this supervisor
        $projects = $this->project->getProjectsByUserId($supervisorId);

        // Pass data to the view
        $this->view('supervisor/event', [
            'project' => $projects
        ]);
    }

    public function addEventForm($project_id)
    {
        $data = [
            'project_id' => $project_id,
            'errors' => []
        ];
        $this->view('supervisor/add_event', $data);
    }


    public function addEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $project_id = $_POST['project_id'] ?? null;
            $event_name = trim($_POST['event_name'] ?? '');
            $date = trim($_POST['date'] ?? '');
            $today = date('Y-m-d');
            $time = trim($_POST['time'] ?? '');
            $location = trim($_POST['location'] ?? '');
            $workers_required = intval($_POST['workers_required'] ?? 0);
            $payment_per_worker = filter_var($_POST['payment_per_worker'] ?? 0, FILTER_VALIDATE_INT);
            $description = trim($_POST['description'] ?? '');
            $errors = [];

            if (!$project_id) {
                $errors[] = 'Invalid project.';
            }
            if (empty($event_name)) {
                $errors[] = 'Event name is required.';
            }
            if (empty($date)) {
                $errors[] = 'Event date is required.';
            } elseif ($date < $today) {
                $errors[] = 'Event date cannot be in the past.';
            }
            if (empty($time)) {
                $errors[] = 'Event time is required.';
            }
            if ($payment_per_worker === false || $payment_per_worker < 0) {
                $errors[] = 'Payment per worker must be a positive integer.';
                $payment_per_worker = 0;
            }


            if (count($errors) == 0) {
                $newEvent = [
                    'project_id' => $project_id,
                    'event_name' => $event_name,
                    'date' => $date,
                    'time' => $time,
                    'location' => $location,
                    'workers_required' => $workers_required,
                    'payment_per_worker' => $payment_per_worker,
                    'description' => $description,
                    'status' => 0,
                    'completion_status' => 'Pending',
                    'postponed_date' => null
                ];

                if ($this->eventModel->addEvent($newEvent)) {
                    // Redirect back to events list
                    redirect('Supervisor/Event/viewEvents', ['project_id' => $project_id]);
                    // } else { $errors[] = 'Failed to add event.';
                }
            }

            // On error, reload events page with errors
            $events = $this->eventModel->getEventsByProject($project_id);
            $data = [
                'project_id' => $project_id,
                'events' => $events,
                'errors' => $errors,
                'form_data' => $_POST
            ];
            $this->view('supervisor/events', $data);
        } else {
            redirect('supervisor/event');
        }
    }

    public function viewEvents()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $project_id = $_POST['project_id'] ?? null;
            if (!$project_id) {
                // Redirect or show error
                redirect('supervisor/event');
            }

            $events = $this->eventModel->getEventsByProject($project_id);

            // Process each event to determine if it's postponed
            foreach ($events as $event) {
                $event->is_postponed = !empty($event->postponed_date);
                $event->display_date = $event->is_postponed ? $event->postponed_date : $event->date;
            }

            $data = [
                'project_id' => $project_id,
                'events' => $events,
                'errors' => []
            ];

            $this->view('supervisor/events', $data);
        } else {
            redirect('supervisor/event');
        }
    }


    public function update($id = null)
    {
        if ($id === null) {
            redirect('Supervisor/Event');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize inputs
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            // Get event details
            $event = $this->eventModel->getEventWithImages($id);

            if (!$event) {
                $_SESSION['message'] = 'Event not found';
                $_SESSION['message_type'] = 'error';
                redirect('Supervisor/Event');
                exit();
            }

            $data = [
                'completion_status' => trim($_POST['completion_status']),
                'progress_notes' => trim($_POST['progress_notes'] ?? '')
            ];

            // Handle image uploads if any
            if (!empty($_FILES['completion_images']['name'][0])) {
                $uploadDir = 'uploads/events/' . $id . '/';

                // Create directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $uploadedImages = [];

                // Process each uploaded file
                foreach ($_FILES['completion_images']['name'] as $key => $name) {
                    if ($_FILES['completion_images']['error'][$key] === 0) {
                        $tmpName = $_FILES['completion_images']['tmp_name'][$key];
                        $fileName = uniqid() . '_' . $name;
                        $destination = $uploadDir . $fileName;

                        if (move_uploaded_file($tmpName, $destination)) {
                            $uploadedImages[] = $destination;
                        }
                    }
                }

                // Get existing images
                $existingImages = [];
                if (!empty($event->completion_images)) {
                    $existingImages = json_decode($event->completion_images, true) ?: [];
                }

                // Merge with new images
                $allImages = array_merge($existingImages, $uploadedImages);
                $data['completion_images'] = json_encode($allImages);
            }

            // Update event
            if ($this->eventModel->updateEvent($id, $data)) {
                $_SESSION['message'] = 'Event updated successfully';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Failed to update event';
                $_SESSION['message_type'] = 'error';
            }

            redirect('Supervisor/Event/viewEvent/' . $id);
            exit();
        } else {
            redirect('Supervisor/Event');
            exit();
        }
    }

    public function delete_image($eventId, $image)
    {
        // Get event details
        $event = $this->eventModel->getEventWithImages($eventId);

        if (!$event) {
            $_SESSION['message'] = 'Event not found';
            $_SESSION['message_type'] = 'error';
            redirect('Supervisor/Event');
            exit();
        }

        // Decode the image path
        $imagePath = urldecode($image);

        // Remove image from filesystem if it exists
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Remove image from database
        if (!empty($event->completion_images)) {
            $images = json_decode($event->completion_images, true) ?: [];
            $images = array_filter($images, function ($img) use ($imagePath) {
                return $img !== $imagePath;
            });

            $this->eventModel->updateEvent($eventId, [
                'completion_images' => json_encode(array_values($images))
            ]);

            $_SESSION['message'] = 'Image deleted successfully';
            $_SESSION['message_type'] = 'success';
        }

        redirect('Supervisor/Event/viewEvent/' . $eventId);
        exit();
    }

    public function postpone_event($event_id)
    {
        // Load the event
        $eventModel = new EventModel();
        $event = $eventModel->first(['id' => $event_id]);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle form submission
            $data = [
                // 'postponed' => 'yes',
                'postpone_details' => $_POST['postpone_reason'],
                'postponed_date' => $_POST['postponed_date'], // Optional: if you want to track when it was postponed
                // 'date' => $_POST['postponed_date']
            ];

            if ($eventModel->update($event_id, $data)) {
                // Success - redirect back to upcoming events
                header('Location: ' . URLROOT . '/sitehead/Event/Upcoming_events');
            } else {
                // Error handling
                die('Something went wrong');
            }
        } else {
            // Show postpone form
            $data = [
                'event' => $event
            ];
            $this->view('sitehead/postpone_form', $data);
        }
    }


    public function viewEvent($id = null)
    {
        if ($id === null) {
            redirect('Supervisor/Event');
            exit();
        }

        // Get event details
        $event = $this->eventModel->getEventWithImages($id);

        if (!$event) {
            $_SESSION['message'] = 'Event not found';
            $_SESSION['message_type'] = 'error';
            redirect('Supervisor/Event');
            exit();
        }

        // Check if event is postponed and set display date
        $event->is_postponed = !empty($event->postponed_date);
        $event->display_date = $event->is_postponed ? $event->postponed_date : $event->date;

        $data = [
            'event' => $event
        ];

        $this->view('supervisor/view_event', $data);
    }
}
