<?php

/**
 * User class
 */
class RLand
{

	use Model;

	protected $table = 'land';

	// protected $order_column = 'landID';

	protected $allowedColumns = [

		'id',
		'registered_date',
		'landowner_id',
		'address',
		'size',
		'duration',
		'crop_type',
		'document',
		'status',
		'zone'

	];

	public function validate($data)
	{
		$this->errors = [];

		if (empty($data['address'])) {
			$this->errors['address'] = " Address is required";
		}

		if (empty($data['size'])) {
			$this->errors['size'] = "size is required";
		}



		if (empty($this->errors)) {
			return true;
		}

		return false;
	}


	//for landowners managelands
	public function findlandsbyuserid($userId){
		$query = "select * from land where landowner_id = $userId";
		$data = [':landowner_id' => $userId]; // Make sure 'userId' is passed correctly

		return $this->query($query);
	}

	public function countLandsByUserId($userId)
	{

		$query = "SELECT COUNT(*) FROM land WHERE landowner_id = :landowner_id";
		$data = [':landowner_id' => $userId]; // Make sure 'userId' is passed correctly

		// Call query
		$result = $this->query($query, $data);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
	}




	public function countProjectsByUserId($userId)
	{

		$query = "SELECT COUNT(*) FROM land WHERE landowner_id = :landowner_id AND status='active'";
		$data = [':landowner_id' => $userId]; // Make sure 'userId' is passed correctly

		// Call query
		$result = $this->query($query, $data);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
	}

	public function countOngoingProjects()
	{

		$query = "SELECT COUNT(*) FROM land WHERE status='active'";
		// Make sure 'userId' is passed correctly

		// Call query
		$result = $this->query($query);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
	}

	public function countcompletedProjectsByUserId($userId)
	{

		$query = "SELECT COUNT(*) FROM land WHERE landowner_id = :landowner_id AND status='completed'";
		$data = [':landowner_id' => $userId]; // Make sure 'userId' is passed correctly

		// Call query
		$result = $this->query($query, $data);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
	}

	public function countcompletedProjects()
	{

		$query = "SELECT COUNT(*) FROM land WHERE  status='completed'";

		// Call query
		$result = $this->query($query);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
	}

	public function countinactivelandsByUserId($userId)
	{

		$query = "SELECT COUNT(*) FROM land WHERE landowner_id = :landowner_id AND status='inactive'";
		$data = [':landowner_id' => $userId]; // Make sure 'userId' is passed correctly

		// Call query
		$result = $this->query($query, $data);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
	}


	public function countinactivelands()
	{

		$query = "SELECT COUNT(*) FROM land WHERE  status='inactive'";

		// Call query
		$result = $this->query($query);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
	}


	public function countLands()
	{
		$query = "SELECT COUNT(*) AS total FROM land";
		$result = $this->query($query);

		return $result ? (int) $result[0]->total : 0;  // Access total as an object property
	}


	public function findOngoingProjects($userId)
	{
		$query = "SELECT * FROM land WHERE status = 'active' AND landowner_id = :landowner_id";

		$data = [':landowner_id' => $userId];

		return $this->query($query, $data);
	}

	public function findCompletedProjects($userId)
	{
		$query = "SELECT * FROM land WHERE status = 'completed' AND landowner_id = :landowner_id";

		$data = [':landowner_id' => $userId];

		return $this->query($query, $data);
	}

	//bar chart
	public function findRegisteredYear()
	{
		$yearLabels = [];
		$yearData = [];

		$query = "SELECT YEAR(registered_date) AS year, COUNT(*) AS count FROM land GROUP BY year ORDER BY year";

		$stmt = $this->query($query);

		if ($stmt) {
			foreach ($stmt as $row) {
				$yearLabels[] = $row->year;
				$yearData[] = $row->count;
			}
		}

		return ['labels' => $yearLabels, 'data' => $yearData];
	}

public function getpendinglands(){
	{
		$query = "SELECT * FROM land WHERE status = 'pending' ";


		return $this->query($query);
	}

}

}
