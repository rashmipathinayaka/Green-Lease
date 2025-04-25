<?php
// app/controllers/Event.php
class Event
{
    use Controller;

    public function index()
    {

        // Default method - you can redirect or show a list
        //header('Location: ' . URLROOT . '/sitehead/Event/details/');
    }

    public function details($eventId = null)
    {
        // Check if user is logged in
        if (!isset($_SESSION['id'])) {
            redirect('login');
            return;
        }

        if (empty($eventId)) {
            $this->view('_404');
            return;
        } 

        // Load required models
        $eventModel = new EventModel();
        $siteheadModel = new Sitehead();
        $projectModel = new Project();

        // Get event details
        $event = $eventModel->getEventWithImages($eventId);

        // Check if event exists
        if (!$event) {
            $this->view('_404');
            return;
        }

        // Get project details
        $project = $projectModel->first(['id' => $event->project_id]);
        if (!$project) {
            $this->view('_404');
            return;
        }

        // Verify sitehead is assigned to this land
        $siteheadAssignment = $siteheadModel->first([
            'user_id' => $_SESSION['id'],
            'land_id' => $project->land_id
        ]);

        if (!$siteheadAssignment) {
            $this->view('_403');
            return;
        }

        // Prepare data for view
        $data = [
            'event' => $event,
            'project' => $project,
            'success' => $_SESSION['success'] ?? null,
            'error' => $_SESSION['error'] ?? null
        ];

        // Clear flash messages
        unset($_SESSION['success']);
        unset($_SESSION['error']);

        $this->view('sitehead/event_details', $data);
    }

    public function update($eventId = null)
    {
        // Check if user is logged in and request is POST
        if (!isset($_SESSION['id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('login');
            return;
        }

        if (empty($eventId)) {
            $_SESSION['error'] = 'Event ID required';
            redirect('sitehead');
            return;
        }

        // Load required models
        $eventModel = new EventModel();
        $siteheadModel = new Sitehead();
        $projectModel = new Project();

        // First verify the sitehead has permission
        $event = $eventModel->first(['id' => $eventId]);
        if (!$event) {
            $_SESSION['error'] = 'Event not found';
            redirect('sitehead');
            return;
        }

        $project = $projectModel->first(['id' => $event->project_id]);
        $siteheadAssignment = $siteheadModel->first([
            'user_id' => $_SESSION['id'],
            'land_id' => $project->land_id
        ]);

        if (!$siteheadAssignment) {
            $_SESSION['error'] = 'Unauthorized to update this event';
            redirect('sitehead');
            return;
        }

        // Prepare update data
        $updateData = [
            'progress_notes' => trim($_POST['progress_notes'] ?? ''),
            'completion_status' => $_POST['completion_status'] ?? 'pending'
        ];

        // Handle file uploads
        if (!empty($_FILES['completion_images']['name'][0])) {
            $uploadedFiles = [];
            $uploadDir = ROOT . '/uploads/event_images/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            foreach ($_FILES['completion_images']['tmp_name'] as $key => $tmpName) {
                if ($_FILES['completion_images']['error'][$key] === UPLOAD_ERR_OK) {
                    $originalName = basename($_FILES['completion_images']['name'][$key]);
                    $fileExt = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                    $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

                    if (in_array($fileExt, $allowedExts)) {
                        $fileName = time() . '_' . $eventId . '_' . uniqid() . '.' . $fileExt;

                        if (move_uploaded_file($tmpName, $uploadDir . $fileName)) {
                            $uploadedFiles[] = $fileName;
                        }
                    }
                }
            }

            if (!empty($uploadedFiles)) {
                // Get existing images (initialize as empty array if null)
                $existingImages = [];
                if ($event->completion_images) {
                    $existingImages = json_decode($event->completion_images, true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $existingImages = []; // Reset if invalid JSON
                    }
                }

                // Merge and encode
                $updateData['completion_images'] = json_encode(array_merge($existingImages, $uploadedFiles));

                // Debug the data being saved
                error_log("Saving images: " . print_r($updateData['completion_images'], true));
            }
        }

        // Attempt to update
        if ($eventModel->update($eventId, $updateData)) {
            $_SESSION['success'] = 'Event updated successfully';
        } else {
            $_SESSION['error'] = 'Failed to update event';
        }

        header('Location: ' . URLROOT . '/sitehead/Index');
    }


    public function delete_image($eventId = null, $imageName = null)
    {
        if (!isset($_SESSION['id'])) {
            redirect('login');
            return;
        }

        if (empty($eventId) || empty($imageName)) {
            $_SESSION['error'] = 'Invalid request';
            redirect('sitehead');
            return;
        }

        $eventModel = new EventModel();
        $siteheadModel = new Sitehead();
        $projectModel = new Project();

        $event = $eventModel->first(['id' => $eventId]);
        if (!$event) {
            $_SESSION['error'] = 'Event not found';
            redirect('sitehead');
            return;
        }

        $project = $projectModel->first(['id' => $event->project_id]);
        $siteheadAssignment = $siteheadModel->first([
            'user_id' => $_SESSION['id'],
            'land_id' => $project->land_id
        ]);

        if (!$siteheadAssignment) {
            $_SESSION['error'] = 'Unauthorized to modify this event';
            redirect('sitehead');
            return;
        }

        if ($event->completion_images) {
            $images = json_decode($event->completion_images, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $updatedImages = array_filter($images, function ($img) use ($imageName) {
                    return $img !== $imageName;
                });

                $imagePath = ROOT . '/uploads/event_images/' . $imageName;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                $eventModel->update($eventId, [
                    'completion_images' => !empty($updatedImages) ? json_encode(array_values($updatedImages)) : null
                ]);

                $_SESSION['success'] = 'Image deleted successfully';
            }
        }

        header('Location: ' . URLROOT . '/sitehead/Event/details/' . $eventId);
    }

    public function Upcoming_events()
    {
        // Get projects managed by this sitehead
        $userId = $_SESSION['id'];

        // Get sitehead's data
        $siteheadModel = new Sitehead();
        $siteheadData = $siteheadModel->first(['user_id' => $userId]);

        if (!empty($siteheadData)) {
            // Get the single active project for this sitehead
            $projectModel = new Project();
            $project = $projectModel->first([
                'sitehead_id' => $siteheadData->id,
                'status' => 'ongoing'
            ]);

            if (!empty($project)) {
                // Get upcoming events for this single project
                $eventModel = new EventModel();
                $upcomingEvents = $eventModel->getUpcomingEvents($project->id);

                $data = [
                    'upcomingEvents' => $upcomingEvents,
                    'project' => $project // Now singular since only one project
                ];

                $this->view('sitehead/upcoming_events', $data);
            } else {
                // No active project found
                $data = [
                    'upcomingEvents' => [],
                    'error' => 'No ongoing project found'
                ];
                $this->view('sitehead/upcoming_events', $data);
            }
        } else {
            // No sitehead data found - handle error
            redirect('sitehead/dashboard');
        }
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
}
