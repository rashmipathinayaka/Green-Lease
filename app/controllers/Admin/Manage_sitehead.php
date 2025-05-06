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
        $this->sitehead = new RSitehead();
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
            header("Location: " . URLROOT . "/Admin/manage_sitehead");
            exit(); 
        } else {
            header("Location: " . URLROOT . "/Admin/sorry_delete_failed");
            exit(); 
        }
    }
    
	


public function update_sitehead()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
        $id = $_POST['id'];

        $updatedata = [
			'id' => $_POST['id'],
            'land_id' => $_POST['land_id'], 
            'status' => $_POST['status'] 
        ];

		
       if( $this->sitehead->update($id, $updatedata, 'id')){
		echo "Data updated successfully.";
	   }

        $newdata = $this->sitehead->getSiteheadDetails();
        $this->view('admin/manage_sitehead', ['data' => $newdata]);
    }
}

public function getid($id){
    echo $id;
    header("Location: " . URLROOT . "/Components/profile/index/{$id}");
}








}