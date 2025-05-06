<?php 
class Index
{
	use Controller;

	public function index()
	{
		if (!isset($_SESSION['id'])) {
			redirect('login');
		}

		$userId = $_SESSION['id'];

		$bidModel = new SBid();
		$data['pending_payments'] = $bidModel->query(
			"SELECT b.*, h.harvest_date 
			 FROM bid b 
			 JOIN harvest h ON b.harvest_id = h.id 
			 WHERE b.buyer_id = :buyer_id 
			 AND b.status = 'Approved'
			 AND b.id NOT IN (SELECT bid_id FROM purchase)",
			['buyer_id' => $_SESSION['id']]
		);

		$pendingPaymentsCount = $bidModel->query(
			"SELECT COUNT(*) as count FROM bid WHERE buyer_id = :buyer_id AND status = 'Approved' AND id NOT IN (SELECT bid_id FROM purchase)",
			['buyer_id' => $_SESSION['id']]
		)[0]->count;

		$bidsPlacedCount = $bidModel->query(
			"SELECT COUNT(*) as count FROM bid WHERE buyer_id = :buyer_id",
			['buyer_id' => $_SESSION['id']]
		)[0]->count;

		$complaintModel = new BuyerComplaint();
		$complaintsFiledCount = $complaintModel->query(
			"SELECT COUNT(*) as count FROM buyer_complaint WHERE buyer_id = :buyer_id",
			['buyer_id' => $_SESSION['id']]
		)[0]->count;

		$totalPurchasesCount = (new Purchase())->query(
			"SELECT COUNT(*) as count FROM purchase p JOIN bid b ON p.bid_id = b.id WHERE b.buyer_id = :buyer_id",
			['buyer_id' => $_SESSION['id']]
		)[0]->count;

		$data['pending_payments_count'] = $pendingPaymentsCount;
		$data['bids_placed_count'] = $bidsPlacedCount;
		$data['complaints_filed_count'] = $complaintsFiledCount;
		$data['total_purchases_count'] = $totalPurchasesCount;

		$userModel = new User();
		$userData = $userModel->first(['id' => $userId]);

		$data['sname'] = $userData->full_name;

		$this->view('buyer/index', $data);
	}

	private function applyForEvent($event_id) {
		$worker_id = $_SESSION['id'];
		$workerEventModel = new WorkerEventModel();

		$existing = $workerEventModel->first([
			'worker_id' => $worker_id,
			'event_id' => $event_id
		]);

		if ($existing) {
			$_SESSION['message'] = 'You have already applied for this event';
			$_SESSION['message_type'] = 'error';
			redirect('worker');
			return;
		}

		$result = $workerEventModel->insert([
			'worker_id' => $worker_id,
			'event_id' => $event_id,
			'status' => 'Pending'
		]);

		if ($result) {
			$_SESSION['message'] = 'Successfully applied for the event';
			$_SESSION['message_type'] = 'success';
		} else {
			$_SESSION['message'] = 'Failed to apply for the event';
			$_SESSION['message_type'] = 'error';
		}

		$eventModel = new Event();
		$event = $eventModel->first(['id' => $event_id]);
		$projectId = $event ? $event->project_id : null;

		$projectModel = new Project();
		$project = $projectModel->first(['id' => $projectId]);
		$siteheadId = $project ? $project->sitehead_id : null;

		$siteheadModel = new Sitehead();
		$sitehead = $siteheadModel->first(['id' => $siteheadId]);
		$siteheadUserId = $sitehead ? $sitehead->user_id : null;

		if ($siteheadUserId) {
			$notificationModel = new Notification();
			$notificationModel->create([
				'user_id' => $siteheadUserId,
				'type' => 'worker_event_applied',
				'message' => "A worker has applied for event ID $event_id.",
				'link' => URLROOT . "/Sitehead/Event/details/$event_id"
			]);
		}

		redirect('worker');
	}

}
