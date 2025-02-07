<?php 

/**
 * home class
 */
class Attendance
{
	use Controller;

	public function index()
	{
		

		$this->view('supervisor/attendance');
	}

}
