<?php
class File_complaint
{
    use Controller;
    
    public function index()
    {
        if(!isset($_SESSION['id'])) {
            header("Location: " . URLROOT . "/login");
            exit();
        }
        
        $buyer_id = $_SESSION['id'];
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $complaint = new BuyerComplaint();
            
            $data = [
                'buyer_id' => $buyer_id,
                'complaint_type' => $_POST['complaint-type'],
                'description' => $_POST['description'],
                'attachment' => ''
            ];
            
            if(!empty($_FILES['attachment']['name'])) {
                $upload_dir = "uploads/complaints/buyer/";
                
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
                $this->view('Buyer/File_complaint', ['success' => 'Your complaint has been submitted successfully!']);
            } else {
                $this->view('Buyer/File_complaint', ['error' => 'Failed to submit complaint. Please try again.']);
            }
        } else {
            $this->view('Buyer/File_complaint');
        }
    }
}