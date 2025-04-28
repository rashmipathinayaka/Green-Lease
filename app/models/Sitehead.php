<?php

/**
 * Sitehead class
 */
class Sitehead
{
	use Model;

	protected $table = 'sitehead';

	protected $allowedColumns = [
		
		'user_id',
		'status',
		'zone',
		'land_id'
	];
// 	public function getInactiveUsers()
// {
//     $query = "SELECT DISTINCT s.user_id, u.full_name
//         FROM sitehead s
//         INNER JOIN user u ON s.user_id = u.id
//         INNER JOIN supervisor sp ON sp.zone = s.zone
//         WHERE s.status = 'Inactive' 
        
//     ";

//     return $this->query($query);
// }



public function getSiteheadsBySupervisorUserId($userId)
{
    $query = "SELECT u.*, s.status, s.land_id
        FROM sitehead s
        INNER JOIN user u ON s.user_id = u.id
        WHERE s.zone = (
            SELECT zone FROM supervisor WHERE user_id = :userId
        ) ";

    return $this->query($query, [
        'userId' => $userId
    ]);
}



public function getInactiveUsers($userId)
{
    $query = "SELECT u.*, s.status, s.land_id
        FROM sitehead s
        INNER JOIN user u ON s.user_id = u.id
        WHERE s.zone = (
            SELECT zone FROM supervisor WHERE user_id = :userId
        ) AND s.status = 'Inactive'";

    return $this->query($query, [
        'userId' => $userId
    ]);
}

    


	public function validate($data)
	{
		$this->errors = [];

		if (empty($data['user_id'])) {
			$this->errors['user_id'] = "User ID is required";
		} elseif (!is_numeric($data['user_id'])) {
			$this->errors['user_id'] = "User ID must be a number";
		}

		if (empty($data['land_id'])) {
			$this->errors['land_id'] = "Land ID is required";
		} elseif (!is_numeric($data['land_id'])) {
			$this->errors['land_id'] = "Land ID must be a number";
		}

		

		return empty($this->errors);
	}
	
	public function isLandAssigned($land_id)
{
    $land_id = addslashes($land_id); // sanitize input to avoid SQL injection
    $query = "SELECT * FROM sitehead WHERE land_id = '$land_id' AND status = 'Active'";
    $result = $this->query($query);
    
    return !empty($result); // if any matching row exists
}


	

	// Additional useful methods
	public function getUserById($user_id)
{
    $query = "SELECT * FROM user WHERE id = :id";
    return $this->query($query, ['id' => $user_id]);
}


	// In your Sitehead model
	public function assignLandToSitehead($land_id, $user_id)
{
    $query = "INSERT INTO sitehead (land_id, user_id) VALUES (:land_id, :user_id)";
    return $this->query($query, [
        'land_id' => $land_id,
        'user_id' => $user_id
    ]);
}
public function updateUser($user_id, $data)
{
    $columns = array_keys($data);
    $setClause = implode(', ', array_map(fn($col) => "$col = :$col", $columns));

    $query = "UPDATE user SET  WHERE id = :user_id";
    $data['user_id'] = $user_id;

    return $this->query($query, $data);
}


}
