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
		$pendingrequests = $this->getFertilizerRequestWithUserDetails('pending');


		$Approvedrequests = $this->getFertilizerRequestWithUserDetails('Approved');

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

	private function getFertilizerRequestWithUserDetails($status)
	{
		$requests = $this->fertilizerRequestModel->where(['status' => $status]);
		$validRequests = [];

		if (!empty($requests)) {
			foreach ($requests as $request) {
				$sitehead = $this->siteheadModel->first(['id' => $request->sitehead_id]);
				$fertilizer = $this->fertilizerModel->first(['id' => $request->fertilizer_id]);
				$project = $this->projectModel->first(['id' => $request->project_id]);

				if (!$sitehead || !$fertilizer || !$project) {
					continue; // Skip invalid records
				}

				$user = $this->userModel->first(['id' => $sitehead->user_id]);

				$request->user_name = $user->full_name ?? 'Unknown';
				$request->contact_no = $user->contact_no ?? 'N/A';
				$request->fertilizer_type = $fertilizer->name;
				$request->crop_type = $project->crop_type;

				$validRequests[] = $request;
			}
		}

		return $validRequests;
	}


	public function markAsAccept($id)
	{
		// Update the fertilizer request status to 'Approved'
		if ($this->fertilizerRequestModel->update($id, ['status' => 'Approved'], 'id')) {
			// Redirect back to the fertilizer management page with success message
			header('Location: ' . URLROOT . '/Supervisor/Manage_fertilizer?success=accepted');
		} else {
			// Show an error page if the update fails
			$this->view('_404');
		}
	}

	public function rejectRequest($id)
	{
		// Delete the fertilizer request
		if ($this->fertilizerRequestModel->delete($id)) {
			// Redirect with a success message
			header('Location: ' . URLROOT . '/Supervisor/Manage_fertilizer?success=rejected');
		} else {
			// Show an error page if deletion fails
			$this->view('_404');
		}
	}

	// Add these methods to your Manage_fertilizer class

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
			$deliveryDate = $_POST['delivery_date'];

			// Verify stock is sufficient
			if ($fertilizer->amount >= $actualAmount) {
				// Update fertilizer stock
				$newAmount = $fertilizer->amount - $actualAmount;
				$this->fertilizerModel->update($fertilizer->id, ['amount' => $newAmount]);

				// Update request status
				$this->fertilizerRequestModel->update($id, [
					'status' => 'Approved',
					'approved_amount' => $actualAmount,
					'actual_delivery_date' => $deliveryDate,
					'processed_at' => date('Y-m-d H:i:s')
				]);

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
