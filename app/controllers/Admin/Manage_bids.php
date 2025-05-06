<?php 

/**
 * home class
 */
class Manage_bids
{
	use Controller;
	private $harvest;
	private $bidModel;
	private $notificationModel;

	public function __construct() {
        $this->harvest = new RHarvest();
        if (!isset($_SESSION['id'])) {
            redirect('login');
        }
        $this->bidModel = new Bid();
        $this->notificationModel = new Notification();
    }

	public function index()
	{
		
		$harvest = $this->harvest->findAll();
        $this->view('admin/manage_bids',['harvest'=> $harvest]);







	}

	public function approve_bid($bid_id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$bid = $this->bidModel->first(['id' => $bid_id]);
			
			if ($bid) {
				$this->bidModel->update($bid_id, ['status' => 'Approved']);
				
				$this->notificationModel->create_notification(
					$bid->buyer_id,
					'Bid Approved',
					"Your bid for {$bid->crop_type} has been approved.",
					'success'
				);
				
				$_SESSION['message'] = 'Bid approved successfully';
				$_SESSION['message_type'] = 'success';
			}
		}
		redirect('admin/manage_bids');
	}

	public function reject_bid($bid_id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$bid = $this->bidModel->first(['id' => $bid_id]);
			
			if ($bid) {
				// Update bid status
				$this->bidModel->update($bid_id, ['status' => 'Rejected']);
				
				// Create notification for the buyer
				$this->notificationModel->create_notification(
					$bid->buyer_id,
					'Bid Rejected',
					"Your bid for {$bid->crop_type} has been rejected.",
					'danger'
				);
				
				$_SESSION['message'] = 'Bid rejected successfully';
				$_SESSION['message_type'] = 'success';
			}
		}
		redirect('admin/manage_bids');
	}

}
