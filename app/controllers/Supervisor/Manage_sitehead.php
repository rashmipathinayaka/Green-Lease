<?php 

/**
 * home class
 */
class Manage_sitehead
{
	use Controller;
private $sitehead;

	public function index()
	{
		$data = $this->sitehead->findAll();
            
        $this->view('supervisor/manage_sitehead', ['data' => $data]);
		
	}

public function __construct() {

$this->sitehead = new Sitehead();

}


public function add_sitehead(){

$data = ['errors'=>[],
'formdata'=>[]
];

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
		'landID' => $_POST['landID'] ?? null,
		'status' => $_POST['status'] ?? null,
	];

	// Validate the form data using the model's validation method
	if($this->sitehead->validate($formData)){
		$this->sitehead->insert($formData);
		
		$data = $this->sitehead->findAll();
	
		$this->view('supervisor/manage_sitehead', ['data' => $data]);
			  
	  }else{
		  echo "Data insertion failed.";
	  }  
  }
}
public function delete_sitehead($id){
	if ($this->sitehead->delete($id)) {
              
		$data = $this->sitehead->findAll();
				  $this->view('supervisor/manage_sitehead', ['data' => $data]);
			   } else {
				   // If deletion fails, show a 404 page or an error message
				   $this->view('_404');
			   }
		   }
		

		   
		public function update_sitehead()
       {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
        $id=$_POST['id'];
        $updatedata = [
			//'id' => $_POST['id'],
            'name' => $_POST['name'], // Supervisor name
            'email' => $_POST['email'], // Supervisor email
            'number' => $_POST['number'], // Supervisor phone number
            'landID' => $_POST['landID'], // Supervisor landID
            'status' => $_POST['status'] // Supervisor status
        ];

		$update_data=['name'=>'name','email'=>'email','number'=>'number','landID'=>'landID','status'=>'status'];

        // Call the update function, passing the ID and updated data
        $this->sitehead->update($id, $updatedata, 'id');
	
	   

        // Fetch updated data and load the view
        $newdata = $this->sitehead->findAll();
        $this->view('supervisor/manage_sitehead', ['data' => $newdata]);
    }
}



}







