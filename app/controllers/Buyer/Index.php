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

		// Get pending payments count
		$pendingPaymentsCount = $bidModel->query(
			"SELECT COUNT(*) as count FROM bid WHERE buyer_id = :buyer_id AND status = 'Approved'",
			['buyer_id' => $_SESSION['id']]
		)[0]->count;

		// Get bids placed count
		$bidsPlacedCount = $bidModel->query(
			"SELECT COUNT(*) as count FROM bid WHERE buyer_id = :buyer_id",
			['buyer_id' => $_SESSION['id']]
		)[0]->count;

		// Get complaints filed count
		$complaintModel = new BuyerComplaint();
		$complaintsFiledCount = $complaintModel->query(
			"SELECT COUNT(*) as count FROM buyer_complaint WHERE buyer_id = :buyer_id",
			['buyer_id' => $_SESSION['id']]
		)[0]->count;

		$data['pending_payments_count'] = $pendingPaymentsCount;
		$data['bids_placed_count'] = $bidsPlacedCount;
		$data['complaints_filed_count'] = $complaintsFiledCount;

		$this->view('buyer/index', $data);
	}

}
