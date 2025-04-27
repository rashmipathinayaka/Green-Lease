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
        // $this->user=new RUser();
        $this->project=new RProject();
        $this->zone=new RZone();
    }

    public function index()
    {

        $full_name = $_GET['full_name'] ?? '';
        $zone = $_GET['zone'] ?? '';
    
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
		
        // Initialize an array to hold errors and form data
        $data = [
            'errors' => [], // Initialize errors
            'formData' => [] // Initialize form data
        ];
        
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $formData = [
                'full_name' => $_POST['full_name'] ?? null,
                'email' => $_POST['email'] ?? null,
                'contact_no' => $_POST['contact_no'] ?? null,
                'zone' => $_POST['zone'] ?? null,
				'status' => $_POST['status'] ?? null,
            ];

            // Validate the form data using the model's validation method
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
            // Redirect to the manage supervisor page after successful deletion
            header("Location: " . URLROOT . "/Admin/manage_supervisor");
            exit(); // Ensure no further code is executed after the redirect
        } else {
            // Redirect to an error page if deletion fails
            header("Location: " . URLROOT . "/Admin/sorry_delete_failed");
            exit(); // Ensure no further code is executed after the redirect
        }
    }
    

	


public function update_supervisor()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
        $id = $_POST['id'];

        // Retrieve other form data
        $updatedata = [
			'id' => $_POST['id'],
            'zone' => $_POST['zone'], // Supervisor zone
            'status' => $_POST['status'] // Supervisor status
        ];

		//$update_data=['name'=>'name','email'=>'email','number'=>'number','zone'=>'zone','status'=>'status'];

        // Call the update function, passing the ID and updated data
       if( $this->supervisor->update($id, $updatedata, 'id')){
		echo "Data updated successfully.";
	   }

        // Fetch updated data and load the view
        $newdata = $this->supervisor->getSupervisorDetails();
        $this->view('admin/manage_supervisor', ['data' => $newdata]);
    }
}

public function getid($id){
    echo $id;
    header("Location: " . URLROOT . "/profile/index/{$id}");
}


public function getsupid($id) {
    // Get project count data for the given supervisor ID
    $data1 = $this->project->projectspersupervisor($id);

    // Load the view and pass the data
    $this->view('admin/manage_supervisor', ['data1' => $data1]);
}




}