<?php

class ReportIssue
{
	use Controller;

	public function index()
	{
		$data = ['errors' => []]; // Initialize errors array

		// Check if form was submitted
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Get form data
			$formData = [
				'sitehead_id' => $_POST['sitehead_id'] ?? null,
				'complaint_type' => $_POST['complaint-type'] ?? null,
				'description' => $_POST['description'] ?? null,
				'attachment' => $_FILES['attachment'] ?? null,
			];
			$formData['status'] = 'pending';

			// Validate the data
			$issueModel = new Issue();
			if ($issueModel->validate($formData)) {
				// // Handle file upload
				if (!empty($formData['attachment']['name'])) {
					$fileName = time() . '_' . $_POST['sitehead_id'] . '_' . basename($formData['attachment']['name']);
					$uploadDir = ROOT . '/../uploads/issues/';
					if (!is_dir($uploadDir)) {
						mkdir($uploadDir, 0777, true);
					}
					move_uploaded_file($formData['attachment']['tmp_name'], $uploadDir . $fileName);
					$formData['attachment'] = $fileName;
				} else {
					$formData['attachment'] = null; // No file uploaded
				}

				// Insert into database
				if (!($issueModel->insert($formData))) {
					// Redirect or show success message
					header('Location: ' . URLROOT . '/sitehead/ReportIssue/IssueSuccess');
					exit;
				} else {
					$data['errors'][] = 'Failed to save the issue. Please try again.';
				}
			} else {
				$data['errors'] = $issueModel->errors; // Collect validation errors
			}
		}

		// Load the view with errors (if any)
		$this->view('sitehead/issue', $data);
	}


	public function IssueSuccess()
	{
		$this->view('sitehead/issue_success');
	}
}
