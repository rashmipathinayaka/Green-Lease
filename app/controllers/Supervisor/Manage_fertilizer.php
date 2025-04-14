<?php

/**
 * home class
 */
class Manage_fertilizer
{
	use Controller;

	private $fertilizerRequestModel;
	private $fertilizerModel;

	public function __construct()
	{
		// Initialize the Issue model in the constructor
		$this->fertilizerRequestModel = new FertilizerRequest();
		$this->fertilizerModel = new Fertilizer();
	}

	public function index()
	{
		$pendingrequests = $this->fertilizerRequestModel->where(['status' => 'pending']);


		$solvedrequests = $this->fertilizerRequestModel->where(['status' => 'solved']);

		$fertilizers = $this->fertilizerModel->findAll();

		$totalStock = $this->fertilizerModel->getTotalFertilizerStock();

		// Pass the data to the view
		$this->view('supervisor/manage_fertilizer', [
			'pendingrequests' => $pendingrequests,
			'solvedrequests' => $solvedrequests,
			'totalStock' => $totalStock,
			'fertilizers' => $fertilizers
		]);
	}

	public function markAsAccept($id)
	{
		// Update the fertilizer request status to 'solved'
		if ($this->fertilizerRequestModel->update($id, ['status' => 'solved'], 'id')) {
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
