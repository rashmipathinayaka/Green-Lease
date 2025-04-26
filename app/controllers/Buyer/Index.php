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

		$userModel = new User();
		$userData = $userModel->first(['id' => $userId]);

		$data['sname'] = $userData->full_name;

		$this->view('buyer/index', $data);
	}

	private function applyForEvent($event_id) {
		$worker_id = $_SESSION['id'];
		$workerEventModel = new WorkerEventModel();

		// Check if worker has already applied
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

		// Store the application
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

		// --- Notification Logic ---
		// 1. Get the project_id from the event
		$eventModel = new Event();
		$event = $eventModel->first(['id' => $event_id]);
		$projectId = $event ? $event->project_id : null;

		// 2. Get the sitehead_id from the project
		$projectModel = new Project();
		$project = $projectModel->first(['id' => $projectId]);
		$siteheadId = $project ? $project->sitehead_id : null;

		// 3. Get the user_id from the sitehead table
		$siteheadModel = new Sitehead();
		$sitehead = $siteheadModel->first(['id' => $siteheadId]);
		$siteheadUserId = $sitehead ? $sitehead->user_id : null;

		// 4. Insert notification for that user
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
