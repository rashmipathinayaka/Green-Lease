<?php 
class Index
{
	use Controller;

	public function index()
	{
		if (!isset($_SESSION['id'])) {
			redirect('login');
		}

		// Get pending payments
		$bidModel = new SBid();
		$data['pending_payments'] = $bidModel->query(
			"SELECT b.*, h.harvest_date 
			 FROM bid b 
			 JOIN harvest h ON b.harvest_id = h.id 
			 WHERE b.buyer_id = :buyer_id 
			 AND b.status = 'Approved'",
			['buyer_id' => $_SESSION['id']]
		);

		$this->view('buyer/index', $data);
	}

}
