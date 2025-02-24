<?php 

/**
 * User class
 */
class Sitehead
{
	
	use Model;

	protected $table = 'siteheads';//me  thamai database eke hadan table ek

	

	protected $allowedColumns = [

		'id',
		'name',
		'email',
		'number',
		'landID',
		'status',
		
		
	];

	public function validate($data)
	{
		$this->errors = [];

		if(empty($data['email']))
		{
			$this->errors['email'] = "email is required";
		}
		
		if(empty($data['name']))
		{
			$this->errors['name'] = "name is required";
		}

        

        if(empty($data['landID']))
		{
			$this->errors['landID'] = "landID is required";
		}
        if(empty($data['status']))
		{
			$this->errors['status'] = "status is required";
		}
		
	

		if(empty($this->errors))
		{
			return true;
		}

		return false;
	}
}