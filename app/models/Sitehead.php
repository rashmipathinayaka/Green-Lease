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
		'zone'
	];
	public function getInactiveUsers()
{
    $query = "SELECT DISTINCT s.user_id, u.full_name
        FROM sitehead s
        INNER JOIN user u ON s.user_id = u.id
        WHERE s.status = 1
    ";

    return $this->query($query);
}

	public function getAllSiteheads($supervisorUserId)
{
    $query = " SELECT u.*, s.status
        FROM sitehead s
        INNER JOIN user u ON s.user_id = u.id
        WHERE s.zone = (
            SELECT zone FROM supervisor WHERE user_id = :supervisorUserId
        )
    ";

    return $this->query($query, [
        'supervisorUserId' => $supervisorUserId
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

		if (!isset($data['status'])) {
			$this->errors['status'] = "Status is required";
		} elseif (!is_numeric($data['status'])) {
			$this->errors['status'] = "Status must be a number";
		}

		return empty($this->errors);
	}
	


	// Additional useful methods
	public function getByUserId($user_id)
	{
		return $this->first(['user_id' => $user_id]);
	}

	public function getByLandId($land_id)
	{
		return $this->first(['land_id' => $land_id]);
	}

	// In your Sitehead model
	public function getAssignedLands($userId)
	{
		$query = "SELECT land_id FROM sitehead WHERE user_id = :user_id";
		return $this->query($query, ['user_id' => $userId]);
	}
}
