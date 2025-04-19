<?php 

/**
 * User class
 */
class Sitehead
{
	
	use Model;

	protected $table = 'sitehead';



	protected $allowedColumns = [

		'id',
		'user_id',
		'land_id',
		'status'
		
		
	];

	public function validate($data)
	{
		$this->errors = [];

		if(empty($data['name']))
		{
			$this->errors['name'] = " name is required";
		}
		
		if(empty($data['email']))
		{
			$this->errors['email'] = "email is required";
		}
		
        if(empty($data['zone']))
		{
			$this->errors['zone'] = "zone is required";
		}
	

		if(empty($this->errors))
		{
			return true;
		}

		return false;
	}
}