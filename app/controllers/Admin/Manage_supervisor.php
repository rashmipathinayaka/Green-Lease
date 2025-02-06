<?php
/**
 * Manage_supervisor class
 */
class Manage_supervisor
{
    use Controller;

    private $supervisor;

    public function __construct() {
        // Initialize the supervisor model
        $this->supervisor = new Supervisor();
    }

    public function index()
    {
        $data = $this->supervisor->findAll();
            
        $this->view('admin/manage_supervisor', ['data' => $data]);
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
                'name' => $_POST['name'] ?? null,
                'email' => $_POST['email'] ?? null,
                'number' => $_POST['number'] ?? null,
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
              
		$data = $this->supervisor->findAll();
				  $this->view('admin/manage_supervisor', ['data' => $data]);
			   } else {
				   // If deletion fails, show a 404 page or an error message
				   $this->view('_404');
			   }
		   }


//  public function update_supervisor(){
	
	
	
//  	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// //raw id
// 	$id = $_POST['id']; 
// 	$updatedata=[
		
// 		'name' => $_POST['name'],
//         'email' => $_POST['email'],
//         'number' => $_POST['number'],
//         'zone' => $_POST['zone'],
//         'status' => $_POST['status']
// 	];

//       $this->supervisor->update($id,$updatedata,'id');

// 	  $data = $this->supervisor->findAll();
// 	$this->view('admin/manage_supervisor', ['data' => $data]);
// }


public function update_supervisor()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the supervisor ID
       // $id = 23; // Extract the supervisor ID from the form
echo $_POST['id'];
$id  = $_POST['id'];
        // Retrieve other form data
        $updatedata = [
			'id' => $_POST['id'],
            'name' => $_POST['name'], // Supervisor name
            'email' => $_POST['email'], // Supervisor email
            'number' => $_POST['number'], // Supervisor phone number
            'zone' => $_POST['zone'], // Supervisor zone
            'status' => $_POST['status'] // Supervisor status
        ];

		//$update_data=['name'=>'name','email'=>'email','number'=>'number','zone'=>'zone','status'=>'status'];

        // Call the update function, passing the ID and updated data
       if( $this->supervisor->update($id, $updatedata, 'id')){
		echo "Data updated successfully.";
	   }

        // Fetch updated data and load the view
        $newdata = $this->supervisor->findAll();
        $this->view('admin/manage_supervisor', ['data' => $newdata]);
    }
}
}