<?php 

/**
 * home class
 */
class Index
{
	use Controller;

	public function index()
	{
		

		$this->view('sitehead/index');
	}

}
