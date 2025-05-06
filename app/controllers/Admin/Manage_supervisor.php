<?php
/**
 * Manage_supervisor class
 */
class Manage_supervisor
{
    use Controller;

    private $supervisor;
    private $user;
    private $project;
    private $zone;

    public function __construct() {
        $this->supervisor = new RSupervisor();
        $this->project=new RProject();
        $this->zone=new RZone();
    }

    public function index()
    {

        $full_name = strtolower($_GET['full_name'] ?? '');
        $zone = $_GET['zone'] ?? '';
        
    echo $zone;

        $filters = [
            'full_name' => $full_name,
            'zone' => $zone
        ];

       $zones=$this->zone->getAllZones();
        
        $data = $this->supervisor->getSupervisorDetails($filters);
            
        $this->view('admin/manage_supervisor', ['data' => $data,'zones' => $zones]);
    
       
    
    }






    public function add_supervisor()
    {
		
        $data = [
            'errors' => [], 
            'formData' => [] 
        ];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData = [
                'full_name' => $_POST['full_name'] ?? null,
                'email' => $_POST['email'] ?? null,
                'contact_no' => $_POST['contact_no'] ?? null,
                'zone' => $_POST['zone'] ?? null,
				'status' => $_POST['status'] ?? null,
            ];

			if($this->supervisor->validate($formData)){
				$this->supervisor->insert($formData);
				$data = $this->supervisor->findAll();
            
                $this->view('admin/manage_supervisor', ['data' => $data]);

			  }else{
				  echo "Data insertion failed.";
			  }  
		  }
  
	  }

      public function delete_supervisor($id){
        if ($this->supervisor->delete($id)) {
            header("Location: " . URLROOT . "/Admin/manage_supervisor");
            exit(); 
        } else {
            header("Location: " . URLROOT . "/Admin/sorry_delete_failed");
            exit(); 
        }
    }
    

	


public function update_supervisor()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
        $id = $_POST['id'];

        $updatedata = [
			'id' => $_POST['id'],
            'zone' => $_POST['zone'], 
            'status' => $_POST['status'] 
        ];

		
       if( $this->supervisor->update($id, $updatedata, 'id')){
		echo "Data updated successfully.";
	   }

        $newdata = $this->supervisor->getSupervisorDetails();
        $this->view('admin/manage_supervisor', ['data' => $newdata]);
    }
}

public function getid($id){
    echo $id;
    header("Location: " . URLROOT . "/profile/index/{$id}");
}


public function getsupid($id) {
    $data1 = $this->project->projectspersupervisor($id);

    $this->view('admin/manage_supervisor', ['data1' => $data1]);
}




}