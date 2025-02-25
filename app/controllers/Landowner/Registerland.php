<?php



class Registerland
{
    use Controller;
    
    public function index()
    {
        $registerland = new Land();
        $data = [
            'errors' => [], // Initialize errors
        ];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData = [
                'address' => $_POST['address'] ?? null,
                'district' => $_POST['district'] ?? null,
                'size' => $_POST['size'] ?? null,
                'duration'  => $_POST['duration'] ?? null,
                'crop' => $_POST['crop'] ?? null,
                'document' => null, // Default to null
            ];
        
            // Define upload directory
            $uploadDir = "uploads/";
        
            // Check if the directory exists, if not, create it
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create directory with full permissions
            }
        
            // Check if a file was uploaded
            if (isset($_FILES['document']) && $_FILES['document']['error'] == UPLOAD_ERR_OK) {
                $fileName = time() . "_" . basename($_FILES['document']['name']); // Add timestamp to avoid duplicate names
                $targetFilePath = "/" .$uploadDir . $fileName;
        
                if (move_uploaded_file($_FILES['document']['tmp_name'], $targetFilePath)) {
                    $formData['document'] = $targetFilePath; // Save the file path
                } else {
                    $data['errors'][] = "Failed to upload document.";
                }
            } else {
                $data['errors'][] = "No document uploaded.";
            }
        
            // Validate and insert data
            if ($registerland->validate($formData) && empty($data['errors'])) {
                $registerland->insert($formData);
            } else {
                echo "Data insertion failed.";
            }
        }
        
            
    
        

        $this->view('landowner/registerland', $data);
    }
}

