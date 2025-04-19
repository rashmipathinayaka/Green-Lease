<?php

class ReportIssue
{
	use Controller;

	public function index()
	{
		$data = ['errors' => []];

		// Check if user is logged in
		if (!isset($_SESSION['id'])) {
			$data['errors'][] = "You must be logged in to report an issue.";
			$this->view('sitehead/issue', $data);
			return;
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$userId = $_SESSION['id'];

			// Get sitehead data with proper error handling
			$sitehead = new Sitehead();
			$siteheadData = $sitehead->first(['user_id' => $userId]);

			if (!$siteheadData) {
				$data['errors'][] = 'No sitehead profile found for your account.';
				$this->view('sitehead/issue', $data);
				return;
			}

			// Prepare form data
			$formData = [
				'sitehead_id' => $siteheadData->id,
				'complaint_type' => $_POST['complaint-type'] ?? null,
				'description' => $_POST['description'] ?? null,
				'attachment' => $_FILES['attachment'] ?? null,
				'status' => 'Pending'
			];

			// Validate the data
			$issueModel = new Issue();
			if ($issueModel->validate($formData)) {
				// Handle file upload
				if (!empty($formData['attachment']['name'])) {
					$fileName = time() . '_' . $userId . '_' . basename($formData['attachment']['name']);
					$uploadDir = ROOT . '/uploads/issues/'; // Changed to web-accessible directory

					if (!is_dir($uploadDir)) {
						mkdir($uploadDir, 0755, true); // More secure permissions
					}

					if (!move_uploaded_file($formData['attachment']['tmp_name'], $uploadDir . $fileName)) {
						$data['errors'][] = 'Failed to upload attachment.';
						$this->view('sitehead/issue', $data);
						return;
					}

					$formData['attachment'] = $fileName;
				} else {
					$formData['attachment'] = null;
				}

				// Insert into database
				if ($issueModel->insert($formData)) {
					header('Location: ' . URLROOT . '/sitehead/ReportIssue/IssueSuccess');
					exit;
				} else {
					$data['errors'][] = 'Failed to save the issue. Please try again.';
				}
			} else {
				$data['errors'] = $issueModel->errors;
			}
		}

		$this->view('sitehead/issue', $data);
	}

	public function IssueSuccess()
	{
		$this->view('sitehead/issue_success');
	}
}
