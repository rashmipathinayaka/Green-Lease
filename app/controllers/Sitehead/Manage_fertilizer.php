<?php

/**
 * home class
 */
class Manage_fertilizer
{
	use Controller;

	public function index()
	{
		$data = ['errors' => []]; // Initialize errors array

		// Check if user is logged in
		if (!isset($_SESSION['id'])) {
			$data['errors'][] = "You must be logged in to report an issue.";
			$this->view('sitehead/issue', $data);
			return;
		}

		$userId = $_SESSION['id'];

		// Get sitehead's data
		$siteheadModel = new Sitehead();
		$siteheadData = $siteheadModel->first(['user_id' => $userId]);

		if (!empty($siteheadData)) {
			// Get project IDs of the sitehead
			$projectModel = new Project();
			$data['projects'] = []; // Initialize empty array

			$projects = $projectModel->where(['land_id' => $siteheadData->land_id]);
			foreach ($projects as $project) {
				$data['projects'][] = $project; // Store full project objects
			}
		}

		// Check if form was submitted
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$formData = [
				'amount' => $_POST['amount'] ?? null,
				'fertilizer_id' => $_POST['fertilizer_id'] ?? null,
				'project_id' => $_POST['project_id'] ?? null,
				'preferred_date' => $_POST['preferred_date'] ?? null,
				'sitehead_id' => $siteheadData->id,
				'remarks' => $_POST['remarks'] ?? null,
			];
			$formData['status'] = 'pending';

			// Validate the data
			$requestModel = new FertilizerRequest();

			if ($requestModel->validate($formData)) {
				if ($requestModel->insert($formData)) {
					header("Location: " . URLROOT . "/Sitehead/Manage_fertilizer/FertilizerRequestSuccess");
					exit;
				} else {
					$data['errors'][] = "Failed to submit the request.";
				}
			} else {
				$data['errors'] = $requestModel->errors;
			}
		}


		// Load the view with errors (if any)

		$this->view('sitehead/manage_fertilizer', $data);
	}

	public function FertilizerRequestSuccess()
	{
		$this->view('sitehead/fertilizer_success');
	}
}
