<?php 

/**
 * home class
 */
class Manage_fertilizer
{
	use Controller;

	public function index()
	{
		

		$this->view('supervisor/manage_fertilizer');
	}

}
