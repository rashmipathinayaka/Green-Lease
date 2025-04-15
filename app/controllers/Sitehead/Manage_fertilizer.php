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

		// Check if form was submitted
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$formData = [
				'amount' => $_POST['amount'] ?? null,
				'type' => $_POST['type'] ?? null,
				//'fertilizer_id' => $_POST['fertilizer_id'] ?? null,
				'project_id' => $_POST['project_id'] ?? null,
				'preferred_date' => $_POST['preferred_date'] ?? null,
				'sitehead_id' => $_POST['sitehead_id'] ?? null,
				'remarks' => $_POST['remarks'] ?? null,
			];
			$formData['status'] = 'pending';

			// Validate the data
			$requestModel = new FertilizerRequest();

			if ($requestModel->validate($formData)) {
				if (!$requestModel->insert($formData)) {
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
