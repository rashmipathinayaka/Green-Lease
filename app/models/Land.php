<?php 

/**
 * User class
 */
class Land
{
	
	use Model;

	protected $table = 'lands';

	// protected $order_column = 'landID';

	protected $allowedColumns = [

		'id',
		'address',
		'size',
		'duration',
		'crop',
		'document',
		'status',
		'district'
		
	];

	public function validate($data)
	{
		$this->errors = [];

		if(empty($data['address']))
		{
			$this->errors['address'] = " Address is required";
		}
		
		if(empty($data['size']))
		{
			$this->errors['size'] = "size is required";
		}
		
	

		if(empty($this->errors))
		{
			return true;
		}

		return false;
	}

	
}