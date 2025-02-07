<?php 

/**
 * home class
 */
class Issue
{
	use Controller;

	public function index()
	{
		

		$this->view('supervisor/issue');
	}

}
