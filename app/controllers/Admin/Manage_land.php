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
       $this-> manageland =new RLand();
    }

	public function index()
	{
        $crop_type = $_GET['crop_type'] ?? '';
        $status = $_GET['status'] ?? '';
    
        $filters = [
            'crop_type' => $crop_type,
            'status' => $status
        ];
    
        $lands = $this->manageland->getFilteredLands($filters);
    
        $this->view('admin/manage_land', ['lands' => $lands]);

        // $lands = $this->manageland->findAll();
        // $this->view('admin/manage_land',['lands'=> $lands]);
		
	}
 

public function updateland($id){
    $data=['status'=>1];
    $this->manageland->update($id,$data,'id');

    $lands = $this->manageland->findAll();
    $this->view('admin/manage_land',['lands'=> $lands]);
}
}
