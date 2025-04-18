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
}
