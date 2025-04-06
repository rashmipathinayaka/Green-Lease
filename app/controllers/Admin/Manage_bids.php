<?php 

/**
 * home class
 */
class Manage_bids
{
	use Controller;
	private $harvest;

	public function __construct() {
        // Initialize the Sitehead model
        $this->harvest = new RHarvest();
    }

	public function index()
	{
		
		$harvest = $this->harvest->findAll();
        $this->view('admin/manage_bids',['harvest'=> $harvest]);







	}

}
