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

	public function countLandsByUserId($userId) {

$query = "SELECT COUNT(*) FROM lands WHERE landowner_id = :landowner_id";
$data = [':landowner_id' => $userId]; // Make sure 'userId' is passed correctly

// Call query
$result = $this->query($query, $data);
return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
}

	


public function countProjectsByUserId($userId) {

	$query = "SELECT COUNT(*) FROM lands WHERE landowner_id = :landowner_id AND status='active'";
	$data = [':landowner_id' => $userId]; // Make sure 'userId' is passed correctly
	
	// Call query
	$result = $this->query($query, $data);
	return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
	}
	

	public function countcompletedProjectsByUserId($userId) {

		$query = "SELECT COUNT(*) FROM lands WHERE landowner_id = :landowner_id AND status='completed'";
		$data = [':landowner_id' => $userId]; // Make sure 'userId' is passed correctly
		
		// Call query
		$result = $this->query($query, $data);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
		}

		
		public function countinactivelandsByUserId($userId) {

			$query = "SELECT COUNT(*) FROM lands WHERE landowner_id = :landowner_id AND status='inactive'";
			$data = [':landowner_id' => $userId]; // Make sure 'userId' is passed correctly
			
			// Call query
			$result = $this->query($query, $data);
			return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
			}


			public function countLands()
			{
				$query = "SELECT COUNT(*) AS total FROM lands";  
				$result = $this->query($query);
				
				return $result ? (int) $result[0]->total : 0;  // Access total as an object property
			}
			


}