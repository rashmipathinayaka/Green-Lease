<?php 

/**
 * home class
 */
class Manage_land
{
	use Controller;
    private $manageland;
    private $cropmodel;
    private $zonemodel;

    public function __construct()
    {
       $this-> manageland =new RLand();
       $this-> cropmodel = new RCrop();
       $this-> zonemodel = new RZone();
    }

	public function index()
	{
        $crop_type = $_GET['crop_type'] ?? ''; 
        $status = $_GET['status'] ?? '';
        $zone_id = $_GET['zone_id'] ?? '';  
    
        $filters = [
            'crop_type' => $crop_type,
            'status' => $status,
            'zone_id' => $zone_id,
        ];
    
$zones=$this->zonemodel->getAllZones();

        $lands = $this->manageland->getFilteredLands($filters);
        //filter karaddi crop eka penna one unoth ganna
// $crop_types = $this->cropmodel->getAllCrops();
    
        $this->view('admin/manage_land', ['lands' => $lands,'zones'=>$zones]);

        
		
	}
 

public function updateland($id){
    $data=['status'=>1];
    $this->manageland->update($id,$data,'id');

    $lands = $this->manageland->findAll();
    $this->view('admin/manage_land',['lands'=> $lands]);
}
}
