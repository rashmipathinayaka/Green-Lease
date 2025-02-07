<?php 

/**
 * home class
 */
class Event
{
	use Controller;

	public function index()
	{
		

		$this->view('supervisor/event');
	}

}
