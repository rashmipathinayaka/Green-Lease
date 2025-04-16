<?php 

/**
 * home class
 */
class Site_visit
{
	use Controller;
private $sitevisit;

	public function __construct(){
      $this->sitevisit = new RSite_visit();
	}



	public function index()
	{
		

$visitdata=$this->sitevisit->getAllSiteVisits();






		$this->view('supervisor/site_visit',$visitdata);
	}

}
