<?php
class File_complaint extends Controller2
{
    
    public function index()
    {
        if(!isset($_SESSION['id'])) {
            header("Location: " . URLROOT . "/login");
            exit();
        }

        $worker_id = $_SESSION['id'];
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $complaint = new WorkerComplaint();
            
            $data = [
                'worker_id' => $worker_id,
                'complaint_type' => $_POST['complaint-type'],
                'description' => $_POST['description'],
                'attachment' => '',
                'site_address' => $_POST['address']
            ];

            if(!empty($_FILES['attachment']['name'])) {
                $upload_dir = "uploads/complaints/worker/";
                
                if(!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $file_name = time() . '_' . $_FILES['attachment']['name'];
                $destination = $upload_dir . $file_name;
                
                if(move_uploaded_file($_FILES['attachment']['tmp_name'], $destination)) {
                    $data['attachment'] = $file_name;
                }
            }

            if($complaint->insert($data)) {
                $this->view('Worker/File_complaint', ['success' => 'Your complaint has been submitted successfully!']);
            } else {
                $this->view('Worker/File_complaint', ['error' => 'Failed to submit complaint. Please try again.']);
            }
        } else {
            $this->view('Worker/File_complaint');
        }
    }
}