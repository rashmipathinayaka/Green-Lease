<?php
class Event
{
    use Controller;

    private $project;
    private $eventModel;

    public function __construct()
    {
        // Initialize the Project and EventModel models in the constructor
        $this->project = new Project();
        $this->eventModel = new EventModel();
    }

    public function index()
    {
        // Get supervisor ID from session (using 1 for testing)
        $supervisorId = $_SESSION['user_id'] ?? 1;
        
        // Get all projects for this supervisor
        $projects = $this->project->getProjectsBySupervisor($supervisorId);
        
        // Pass data to the view
        $this->view('supervisor/event', [
            'project' => $projects
        ]);
    }
    
    public function viewEvents()
    {
        // Get project ID from either POST or GET
        $projectId = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $projectId = $_POST['project_id'] ?? null;
        } else if (isset($_GET['project_id'])) {
            $projectId = $_GET['project_id'];
        }
        
        if (empty($projectId)) {
            $_SESSION['message'] = 'No project selected';
            $_SESSION['message_type'] = 'error';
            redirect('Supervisor/Event');
            exit();
        }
        
        // Get events for this project
        $events = $this->eventModel->getEventsByProject($projectId);
        
        // Get project details
        $project = $this->project->getProjectById($projectId);
        
        // Pass data to the view
        $this->view('supervisor/project_events', [
            'events' => $events,
            'project' => $project
        ]);
    }
    
    public function addEvent()
    {
        // If this is a GET request, show the add event form
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Get project_id from query string
            $projectId = $_GET['project_id'] ?? null;
            
            if (empty($projectId)) {
                $_SESSION['message'] = 'No project selected';
                $_SESSION['message_type'] = 'error';
                redirect('Supervisor/Event');
                exit();
            }
            
            // Get project details
            $project = $this->project->getProjectById($projectId);
            
            // Pass data to the view
            $this->view('supervisor/add_event', [
                'project' => $project
            ]);
            return;
        }
        
        // If this is a POST request, process the form submission
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
                'status' => isset($_POST['status']) ? intval($_POST['status']) : 0,
                'description' => trim($_POST['description'] ?? ''),
                'completion_status' => 'pending'
            ];
            
            // Validate inputs
            $errors = [];
            
            if (empty($data['event_name'])) {
                $errors['event_name'] = 'Event name is required';
            }
            
            if (empty($data['date'])) {
                $errors['date'] = 'Date is required';
            }
            
            if (empty($data['time'])) {
                $errors['time'] = 'Time is required';
            }
            
            // If there are errors, redisplay the form
            if (!empty($errors)) {
                // Get project details
                $project = $this->project->getProjectById($data['project_id']);
                
                $this->view('supervisor/add_event', [
                    'project' => $project,
                    'data' => $data,
                    'errors' => $errors
                ]);
                return;
            }
            
            // Add event to database
            if ($this->eventModel->addEvent($data)) {
                $_SESSION['message'] = 'Event added successfully';
                $_SESSION['message_type'] = 'success';
                redirect('Supervisor/Event/viewEvents?project_id=' . $data['project_id']);
                exit();
            } else {
                $_SESSION['message'] = 'Failed to add event';
                $_SESSION['message_type'] = 'error';
                
                // Get project details
                $project = $this->project->getProjectById($data['project_id']);
                
                $this->view('supervisor/add_event', [
                    'project' => $project,
                    'data' => $data
                ]);
            }
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
        
        // Get project details
        $project = $this->project->getProjectById($event->project_id);
        
        $this->view('supervisor/event_details', [
            'event' => $event,
            'project' => $project
        ]);
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
            $images = array_filter($images, function($img) use ($imagePath) {
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
    
    public function postpone_event($id = null)
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
        
        // Set postponed date to 7 days from now
        $postponedDate = date('Y-m-d', strtotime('+7 days'));
        
        // Update event
        if ($this->eventModel->updateEvent($id, ['postponed_date' => $postponedDate])) {
            $_SESSION['message'] = 'Event postponed successfully';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Failed to postpone event';
            $_SESSION['message_type'] = 'error';
        }
        
        redirect('Supervisor/Event/viewEvents?project_id=' . $event->project_id);
        exit();
    }
}
