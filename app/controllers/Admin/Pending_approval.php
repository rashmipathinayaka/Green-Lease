<?php 

/**
 * home class
 */
class Pending_approval
{
	use Controller;
    private $manageland;
    public function __construct()
    {
       $this-> manageland =new RLand();

    }

	public function index()
	{
        $lands = $this->manageland->getpendinglands();
        $this->view('admin/pending_approval',['lands'=> $lands]);
		
	}



    public function getland($id){
echo $id;
     $land_id=$id;
     header("Location: " . URLROOT . "/admin/site_visit/index/{$land_id}");

    }
  
}