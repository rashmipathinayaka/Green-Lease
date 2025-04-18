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

		$query = "SELECT COUNT(*) FROM land WHERE landowner_id = :landowner_id AND status='2'";
		$data = [':landowner_id' => $userId]; // Make sure 'userId' is passed correctly

		// Call query
		$result = $this->query($query, $data);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
	}

	public function countOngoingProjects()
	{

		$query = "SELECT COUNT(*) FROM land WHERE status='2'";
		// Make sure 'userId' is passed correctly

		// Call query
		$result = $this->query($query);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
	}

	public function countcompletedProjectsByUserId($userId)
	{

		$query = "SELECT COUNT(*) FROM land WHERE landowner_id = :landowner_id AND status='3'";
		$data = [':landowner_id' => $userId]; // Make sure 'userId' is passed correctly

		// Call query
		$result = $this->query($query, $data);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
	}

	public function countcompletedProjects()
	{

		$query = "SELECT COUNT(*) FROM land WHERE  status='3'";

		// Call query
		$result = $this->query($query);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
	}

	public function countinactivelandsByUserId($userId)
	{

		$query = "SELECT COUNT(*) FROM land WHERE landowner_id = :landowner_id AND status='4'";
		$data = [':landowner_id' => $userId]; // Make sure 'userId' is passed correctly

		// Call query
		$result = $this->query($query, $data);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
	}


	public function countinactivelands()
	{

		$query = "SELECT COUNT(*) FROM land WHERE  status='4'";

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
		$query = "SELECT * FROM land WHERE status = '2' AND landowner_id = :landowner_id";

		$data = [':landowner_id' => $userId];

		return $this->query($query, $data);
	}

	public function findCompletedProjects($userId)
	{
		$query = "SELECT * FROM land WHERE status = '3' AND landowner_id = :landowner_id";

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



public function getFilteredLands($filters = []) {
    $query = "SELECT * FROM land WHERE 1=1";
    $params = [];

    if (!empty($filters['crop_type'])) {
        $query .= " AND crop_type LIKE ?";
        $params[] = "%" . $filters['crop_type'] . "%";
    }

    if ($filters['status'] !== '') {
        $query .= " AND status = ?";
        $params[] = $filters['status'];
    }

    return $this->query($query, $params);
}

}