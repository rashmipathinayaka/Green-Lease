<?php 

/**
 * home class
 */
class Manage_buyer
{
	private $buyer;
	use Controller;

	public function __construct()
	{
		$this->buyer=new RBuyer();

	}



	public function index()
	{
		$full_name = $_GET['full_name'] ?? '';
    
        $filters = [
            'full_name' => $full_name,
		];

		$data=$this->buyer->getbuyerdetails();		
		$this->view('admin/manage_buyer',['data'=>$data]);
	}

	public function getid($id){
		echo $id;
		header("Location: " . URLROOT . "/profile/index/{$id}");
	}






}
