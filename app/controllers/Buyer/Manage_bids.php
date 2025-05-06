<?php 
class Manage_bids
{
	use Controller;

	private $bidModel;

	public function __construct()
	{
		if (!isset($_SESSION['id'])) {
			redirect('login');
		}
		$this->bidModel = new SBid();
	}

	public function index()
	{
		$status = isset($_GET['status']) ? $_GET['status'] : '';
		$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
		$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';

		$all_bids = $this->bidModel->getBidsByBuyer($_SESSION['id']);

		$active_bids = array_filter($all_bids, function($bid) use ($status, $date_from, $date_to) {
			if ($status && $bid->status !== $status) return false;
			if ($date_from && strtotime($bid->bidding_date) < strtotime($date_from)) return false;
			if ($date_to && strtotime($bid->bidding_date) > strtotime($date_to)) return false;
			return in_array($bid->status, ['Pending', 'Approved']);
		});

		$bid_history = array_filter($all_bids, function($bid) use ($status, $date_from, $date_to) {
			if ($status && $bid->status !== $status) return false;
			if ($date_from && strtotime($bid->bidding_date) < strtotime($date_from)) return false;
			if ($date_to && strtotime($bid->bidding_date) > strtotime($date_to)) return false;
			return in_array($bid->status, ['Not Approved', 'Rejected (No Payment)', 'Completed']);
		});

		$data = [
			'active_bids' => array_values($active_bids),
			'bid_history' => array_values($bid_history)
		];

		$this->view('buyer/manage_bids', $data);
	}

	public function removeBid($id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			if ($this->bidModel->removeBid($id)) {
				$_SESSION['message'] = 'Bid removed successfully';
				$_SESSION['message_type'] = 'success';
			} else {
				$_SESSION['message'] = 'Failed to remove bid';
				$_SESSION['message_type'] = 'error';
			}
			redirect('Buyer/Manage_bids');
		}
	}
}
