<?php

/**
 * home class
 */
class Manage_fertilizer
{
	use Controller;

	private $fertilizerRequestModel;
	private $fertilizerModel;
	private $siteheadModel;
	private $userModel;
	private $projectModel;

	public function __construct()
	{
		// Initialize the Issue model in the constructor
		$this->fertilizerRequestModel = new FertilizerRequest();
		$this->fertilizerModel = new Fertilizer();
		$this->siteheadModel = new sitehead();
		$this->userModel = new User();
		$this->projectModel = new Project();
	}

	public function index()
	{

		$data = ['errors' => []]; // Initialize errors array

		// Check if user is logged in
		if (!isset($_SESSION['id'])) {
			$this->view('404');
			return;
		}

		$userId = $_SESSION['id'];

		// Get sitehead's data
		$supervisorModel = new supervisor();
		$supervisorData = $supervisorModel->first(['user_id' => $userId]);

		if (!empty($supervisorData)) {
			// Get project IDs of the superviosr
			$projectModel = new Project();
			$data['projects'] = []; // Initialize empty array

			$projects = $projectModel->where([
				'supervisor_id' => $supervisorData->id,
				'status' => 'ongoing'
			]);
			foreach ($projects as $project) {
				$data['projects'][] = $project; // Store full project objects
			}

			$pendingrequests = $this->getFertilizerRequestWithUserDetails('pending', $projects);


			$Approvedrequests = $this->getFertilizerRequestWithUserDetails('Approved', $projects);

			$fertilizers = $this->fertilizerModel->findAll();

			$totalStock = $this->fertilizerModel->getTotalFertilizerStock();

			// Pass the data to the view
			$this->view('supervisor/manage_fertilizer', [
				'pendingrequests' => $pendingrequests,
				'Approvedrequests' => $Approvedrequests,
				'totalStock' => $totalStock,
				'fertilizers' => $fertilizers
			]);
		}
	}

	private function getFertilizerRequestWithUserDetails($status, $SupervisorProjects)
	{
		$validRequests = [];

		foreach ($SupervisorProjects as $project) {
			$requests = $this->fertilizerRequestModel->where([
				'status' => $status,
				'project_id' => $project->id
			]);

			if (!empty($requests)) {
				foreach ($requests as $request) {
					$sitehead = $this->siteheadModel->first(['id' => $request->sitehead_id]);
					$fertilizer = $this->fertilizerModel->first(['id' => $request->fertilizer_id]);

					if (!$sitehead || !$fertilizer || !$project) {
						continue;
					}

					$user = $this->userModel->first(['id' => $sitehead->user_id]);

					$request->user_name = $user->full_name ?? 'Unknown';
					$request->contact_no = $user->contact_no ?? 'N/A';
					$request->fertilizer_type = $fertilizer->name;
					$request->crop_type = $project->crop_type;

					$validRequests[] = $request;
				}
			}
		}

		return $validRequests;
	}

	public function approveRequest($id)
	{
		// Get the request details with user info
		$request = $this->fertilizerRequestModel->first(['id' => $id]);

		if (!$request) {
			header('Location: ' . URLROOT . '/Supervisor/Manage_fertilizer');
			exit();
		}

		// Get additional details
		$sitehead = $this->siteheadModel->first(['id' => $request->sitehead_id]);
		$fertilizer = $this->fertilizerModel->first(['id' => $request->fertilizer_id]);
		$project = $this->projectModel->first(['id' => $request->project_id]);
		$user = $this->userModel->first(['id' => $sitehead->user_id]);

		// Add details to request object
		$request->user_name = $user->full_name ?? 'Unknown';
		$request->fertilizer_type = $fertilizer->name;
		$request->crop_type = $project->crop_type;

		// Load the approval view
		$this->view('supervisor/fertilizer_approval', [
			'request' => $request,
			'fertilizer' => $fertilizer
		]);
	}
	
	public function processApproval($id)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Get the request and fertilizer details
			$request = $this->fertilizerRequestModel->first(['id' => $id]);
			$fertilizer = $this->fertilizerModel->first(['id' => $request->fertilizer_id]);

			$actualAmount = (float)$_POST['actual_amount'];
			$planned_Date = $_POST['planned_date'];
			$Notes = $_POST['notes'];

			// Verify stock is sufficient
			if ($fertilizer->amount >= $actualAmount) {
				// Update fertilizer stock
				$newAmount = $fertilizer->amount - $actualAmount;
				$this->fertilizerModel->update($fertilizer->id, ['amount' => $newAmount]);

				// Update request status
				$this->fertilizerRequestModel->update($id, [
					'status' => 'Approved',
					'approvedAmount' => $actualAmount,
					'plannedDate' => $planned_Date,
					'AdditionalNotes' => $Notes
				]);

				// $formData = [
				// 	'actualAmount' => $_POST['actual_amount'] ?? null,
				// 	'plannedDate' => $_POST['delivery_date'] ?? null
				// ];

				// $requestModel = new FertilizerRequest();
				// $requestModel->insert($formData);

				// Redirect with success message
				header('Location: ' . URLROOT . '/Supervisor/Manage_fertilizer?success=approved');
			} else {
				// Redirect with error message
				header('Location: ' . URLROOT . '/Supervisor/Manage_fertilizer?error=insufficient_stock');
			}
			exit();
		}

		// If not POST, redirect back
		header('Location: ' . URLROOT . '/Supervisor/manage_fertilizer');
		exit();
	}
}
