<?php 

/**
 * home class
 */
class Manage_worker
{
	use Controller;

	public function index()
	{
		

		$this->view('supervisor/manage_worker');
	}

}
