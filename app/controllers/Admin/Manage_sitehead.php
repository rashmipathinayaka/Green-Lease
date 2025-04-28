<?php
/**
 * Manage_supervisor class
 */
class Manage_sitehead
{
    use Controller;

    private $sitehead;
    private $user;
    private $project;

    public function __construct() {
        // Initialize the sitehead model
        $this->sitehead = new RSitehead();
        // $this->user=new RUser();
        $this->project=new RProject();
    }

    public function index()
    {

        $full_name = $_GET['full_name'] ?? '';
        $land_id = $_GET['land_id'] ?? '';
    
        $filters = [
            'full_name' => $full_name,
            'land_id' => $land_id
        ];
        $data = $this->sitehead->getSiteheadDetails($filters);
           
        $this->view('admin/manage_sitehead', ['data' => $data]);
    }

  

    public function delete_sitehead($id){
        if ($this->sitehead->delete($id)) {
            // Redirect to the manage sitehead page after successful deletion
            header("Location: " . URLROOT . "/Admin/manage_sitehead");
            exit(); // Ensure no further code is executed after the redirect
        } else {
            // Redirect to an error page if deletion fails
            header("Location: " . URLROOT . "/Admin/sorry_delete_failed");
            exit(); // Ensure no further code is executed after the redirect
        }
    }
    
	


public function update_sitehead()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
        $id = $_POST['id'];

        // Retrieve other form data
        $updatedata = [
			'id' => $_POST['id'],
            'land_id' => $_POST['land_id'], // sitehead zone
            'status' => $_POST['status'] // sitehead status
        ];

		//$update_data=['name'=>'name','email'=>'email','number'=>'number','zone'=>'zone','status'=>'status'];

        // Call the update function, passing the ID and updated data
       if( $this->sitehead->update($id, $updatedata, 'id')){
		echo "Data updated successfully.";
	   }

        // Fetch updated data and load the view
        $newdata = $this->sitehead->getSiteheadDetails();
        $this->view('admin/manage_sitehead', ['data' => $newdata]);
    }
}

public function getid($id){
    echo $id;
    header("Location: " . URLROOT . "/Components/profile/index/{$id}");
}








}