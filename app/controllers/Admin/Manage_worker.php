<?php 

/**
 * home class
 */
class Manage_worker
{
	private $worker;
	use Controller;

	public function __construct()
	{
		$this->worker=new RWorker();

	}



	public function index()
	{
		$full_name = $_GET['full_name'] ?? '';
    
        $filters = [
            'full_name' => $full_name,
		];

		$data=$this->worker->getworkerdetails($filters);		
		$this->view('admin/manage_worker',['data'=>$data]);
	}

	public function getid($id){
		echo $id;
		header("Location: " . URLROOT . "/profile/index/{$id}");
	}






}
