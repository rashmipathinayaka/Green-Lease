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
	private $projectModel;

	public function __construct()
	{
		// Initialize all required models
		$this->fertilizerRequestModel = new FertilizerRequest();
		$this->fertilizerModel = new Fertilizer();
		$this->siteheadModel = new Sitehead();  // Make sure Sitehead model exists
		$this->projectModel = new Project();    // Make sure Project model exists
	}

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
			// $data['projects'] = []; // Initialize empty array

			$projects = $projectModel->first([
				'sitehead_id' => $siteheadData->id,
				'status' => 'ongoing'
			]);

			// foreach ($projects as $project) {
			// 	$data['projects'][] = $project; // Store full project objects
			// }

			// Fetch all fertilizers from database
			$fertilizerModel = new Fertilizer();
			$fertilizers = $fertilizerModel->findAll();
			foreach ($fertilizers as $fertilizer) {
				$data['fertilizers'][] = $fertilizer;
			}
		}

		// Check if form was submitted
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$formData = [
				'amount' => $_POST['amount'] ?? null,
				'fertilizer_id' => $_POST['fertilizer_id'] ?? null,
				'project_id' => $projects->id,
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

	public function requests()
	{
		// Check if user is logged in
		if (!isset($_SESSION['id'])) {
			redirect('login');
			return;
		}

		// Get current sitehead ID
		$sitehead = $this->siteheadModel->first(['user_id' => $_SESSION['id']]);

		if (!$sitehead) {
			$this->view('_404');
			return;
		}

		// Get all requests for this sitehead
		$requests = $this->fertilizerRequestModel->where(
			['sitehead_id' => $sitehead->id],  // $data
			[]  // $data_not (must be array)
		);

		// Manually sort by ID descending since we can't pass order params
		// usort($requests, function ($a, $b) {
		// 	return $b->id - $a->id;
		// });

		// Enhance requests with additional data
		$enhancedRequests = [];
		foreach ($requests as $request) {
			$fertilizer = $this->fertilizerModel->first(['id' => $request->fertilizer_id]);
			$project = $this->projectModel->first(['id' => $request->project_id]);

			$enhancedRequests[] = (object) array_merge((array) $request, [
				'fertilizer_name' => $fertilizer->name ?? 'Unknown',
				'project_name' => $project->crop_type ?? 'Unknown Project',
				'land_id' => $project->land_id ?? 'N/A'
			]);
		}

		$this->view('sitehead/fertilizer_requests', [
			'requests' => $enhancedRequests
		]);
	}

	public function requestDetails($requestId)
	{
		$request = $this->fertilizerRequestModel->first(['id' => $requestId]);

		if (!$request) {
			$this->view('_404');
			return;
		}

		// Enhance request data
		$fertilizer = $this->fertilizerModel->first(['id' => $request->fertilizer_id]);
		$project = $this->projectModel->first(['id' => $request->project_id]);

		$enhancedRequest = (object) array_merge((array) $request, [
			'fertilizer_name' => $fertilizer->name ?? 'Unknown',
			'project_name' => $project->crop_type ?? 'Unknown Project',
			'land_id' => $project->land_id ?? 'N/A'
		]);

		$this->view('sitehead/request_details', [
			'request' => $enhancedRequest
		]);
	}
}
