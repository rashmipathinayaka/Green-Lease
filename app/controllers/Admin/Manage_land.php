<?php 

/**
 * home class
 */
class Manage_land
{
	use Controller;
    private $manageland;
    public function __construct()
    {
       $this-> manageland =new Land();
    }

	public function index()
	{
        $lands = $this->manageland->findAll();
        $this->view('admin/manage_land',['lands'=> $lands]);
		
	}


public function updateland($id){
    $data=['status'=>1];
    $this->manageland->update($id,$data,'id');

    $lands = $this->manageland->findAll();
    $this->view('admin/manage_land',['lands'=> $lands]);
}
}
