<?php



class Registerland
{
    use Controller;
    private $crop_types;
    private $zonemodel;

    public function __construct()
    {
        $this->crop_types = new RCrop();
        $this->zonemodel = new RZone();
    }

    public function index() 
    {
        $registerland = new RLand();
        $harvest = new Rsite_visit();
        $userId = $_SESSION['id']; 
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $crop_type = $_POST['crop_type'] ?? null;
    
            if (!empty($crop_type) && !$this->crop_types->cropExists($crop_type)) {
                $this->crop_types->insertNewCrop($crop_type);
            }


          
            $formData = [
                'landowner_id' => $userId,
                'address' => $_POST['address'] ?? null,
                'zone' => $_POST['zone_id'] ?? null,
                'size' => $_POST['size'] ?? null,
                'duration'  => $_POST['duration'] ?? null,
                'crop_type' => $crop_type,
                'from_date'=>$_POST['from_date'] ?? null,
                'to_date'=>$_POST['to_date'] ?? null,
                'document' => null,
                'status'=>'1',
                'latitude'=>$_POST['latitude'],
                'longitude'=>$_POST['longitude'],
            ];
    
            
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    
            if (isset($_FILES['document']) && $_FILES['document']['error'] == UPLOAD_ERR_OK) {
                $fileName = time() . "_" . basename($_FILES['document']['name']);
                $targetFilePath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['document']['tmp_name'], $targetFilePath)) {
                    $formData['document'] = $targetFilePath;
                } else {
                    $data['errors'][] = "Failed to upload document.";
                }
            } else {
                $data['errors'][] = "No document uploaded.";
            }
    
            if ($registerland->validate($formData) && empty($data['errors'])) {
               if( $registerland->insert($formData)){
                echo "hariiiiii";
               };
                $land_id = $registerland->takeLandId();
    
                $harvest->insert([
                    'land_id' => $land_id,
                    'from_date' => $formData['from_date'],
                    'to_date' => $formData['to_date']
                ]);
    
                header("Location: " . URLROOT . "/landowner/registeredland");
                exit();
            } else {
                echo "Data insertion failed.";
            }
        }
    
        $crops = $this->crop_types->getAllCrops();
$zones=$this->zonemodel->getAllZones();

        $data = [
            'errors' => [],
            'crop_types' => $crops,
            'zones'=>$zones
        ];
    
        $this->view('landowner/registerland', $data);
    }
    
}
