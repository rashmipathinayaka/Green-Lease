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
		'zone',
		'longitude',
		'latitude',

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
		if (empty($data['duration'])) {
			$this->errors['duration'] = "Duration is required";
		}
		if (empty($data['crop_type'])) {
			$this->errors['crop_type'] = "Crop type is required";
		}
		


		if (empty($this->errors)) {
			return true;
		}

		return false;
	}


	//for landowners managelands
	public function findlandsbyuserid($userId)
	{
		$query = "SELECT land.*, project.crop_type  AS selected_crop_type
				  FROM land
				  LEFT JOIN project ON project.land_id = land.id
				  WHERE land.landowner_id = :landowner_id";
		$data = [':landowner_id' => $userId];

		return $this->query($query, $data);
	}


	public function countLandsByUserId($userId)
	{

		$query = "SELECT COUNT(*) FROM land WHERE landowner_id = :landowner_id";
		$data = [':landowner_id' => $userId]; 

		$result = $this->query($query, $data);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  
	}




	public function countProjectsByUserId($userId)
	{

		$query = "SELECT COUNT(*) FROM land WHERE landowner_id = :landowner_id AND status='2'";
		$data = [':landowner_id' => $userId]; 

		$result = $this->query($query, $data);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  
	}

	public function countOngoingProjects()
	{

		$query = "SELECT COUNT(*) FROM land WHERE status='2'";
		$result = $this->query($query);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  
	}

	public function countcompletedProjectsByUserId($userId)
	{

		$query = "SELECT COUNT(*) FROM land WHERE landowner_id = :landowner_id AND status='3'";
		$data = [':landowner_id' => $userId]; 
		$result = $this->query($query, $data);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0; 
	}

	public function countcompletedProjects()
	{

		$query = "SELECT COUNT(*) FROM land WHERE  status='3'";
		$result = $this->query($query);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0; 
	}

	public function countinactivelandsByUserId($userId)
	{

		$query = "SELECT COUNT(*) FROM land WHERE landowner_id = :landowner_id AND status='4'";
		$data = [':landowner_id' => $userId]; 

		$result = $this->query($query, $data);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0; 
	}


	public function countinactivelands()
	{

		$query = "SELECT COUNT(*) FROM land WHERE  status='4'";

		// Call query
		$result = $this->query($query);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  
	}


	public function countLands()
	{
		$query = "SELECT COUNT(*) AS total FROM land";
		$result = $this->query($query);

		return $result ? (int) $result[0]->total : 0;  
	}


	public function findOngoingProjects($userId)
	{
		$query = "SELECT project.*
FROM project
JOIN land ON project.land_id = land.id
WHERE project.status = 'ongoing' AND land.landowner_id = :landowner_id
";

		$data = [':landowner_id' => $userId];

		return $this->query($query, $data);
	}

	public function findCompletedProjects($userId)
	{
		$query = "SELECT project.*
		FROM project
		JOIN land ON project.land_id = land.id
		WHERE land.landowner_id = :landowner_id
		";
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

	public function getpendinglands()
	{
		$query = "SELECT * 
			FROM land 
			WHERE status = '1' 
			AND id IN (
				SELECT land_id 
				FROM site_visit 
				WHERE supervisor_id = '0'
			)
		";

		return $this->query($query);
	}





	//for admins manageland section
	public function getFilteredLands($filters = [])
	{
		$query = "SELECT land.*, zone.zone_name, project.id AS project_id
	FROM land 
	JOIN zone ON land.zone = zone.id 
	LEFT JOIN project ON project.land_id = land.id
	WHERE 1=1";


		$params = [];

		if (!empty($filters['crop_type'])) {
			$query .= " AND crop_type LIKE ?";
			$params[] = "%" . $filters['crop_type'] . "%";
		}

		if ($filters['status'] !== '') {
			$query .= " AND land.status = ?";
			$params[] = $filters['status'];
		}
		

		if (!empty($filters['zone_id'])) {
			$query .= " AND land.zone = ?";
			$params[] = $filters['zone_id'];
		}

		$query .= " ORDER BY registered_date DESC";

		return $this->query($query, $params);
	}



	public function takeLandId()
	{
		$query = 'SELECT id FROM land ORDER BY id DESC LIMIT 1';
		$result = $this->query($query); 
		if ($result && isset($result[0]->id)) {
			return $result[0]->id;
		}
		return null;
	}



	public function getRegisteredLandsCount()
	{
		$query = "SELECT COUNT(*) as count FROM land";

		return (int) $this->query($query)[0]->count; 
	}

	public function getSupervisorsCount()
	{
		$query = "SELECT COUNT(*) as count FROM user WHERE role_id = '2'";
		return (int) $this->query($query)[0]->count; 
	}

	

//landowenr reject lands
public function rejectland($id){
	$query="UPDATE land SET status='4' where  id = :id";
	$data = [':id' => $id];

	
		return $this->query($query, $data);
}







}
