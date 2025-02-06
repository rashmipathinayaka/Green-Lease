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
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
          

           $formData =[
                'address' => $_POST['address'] ?? null,
                'size' => $_POST['size'] ?? null,
                'duration'  => $_POST['duration'], 
                'crop' => $_POST['crop'] ?? null,
               //  'document' => $_POST['document'] ?? null,
                
            ];
            if($registerland->validate($formData)){
              $registerland->insert($formData);
                    
            }else{
                echo "Data insertion failed.";
            }
          
            
            
        }

        $this->view('landowner/registerland', $data);
    }
}

