<?php 
class Index
{
	use Controller;

	public function index()
	{
		$this->view('buyer/index');
	}

}
