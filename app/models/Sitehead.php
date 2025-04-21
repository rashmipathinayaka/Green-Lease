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
		'name',
		'land_id',
		'address',
		'status'
	];

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
