<?php
class Manage_worker
{
	use Controller;

	public function index()
	{
		if (!isset($_SESSION['id'])) {
			redirect('login');
		}

		$userId = $_SESSION['id'];

		// Get sitehead's data
		$siteheadModel = new Sitehead();
		$siteheadData = $siteheadModel->first(['user_id' => $userId]);

		if (!$siteheadData) {
			die('Sitehead data not found');
		}

		// Get the ongoing project for this sitehead
		$projectModel = new Project();
		$project = $projectModel->first([
			'sitehead_id' => $siteheadData->id,
			'status' => 'ongoing'
		]);

		if (!$project) {
			$data = [
				'workers' => [],
				'error' => 'No ongoing project found'
			];
			$this->view('sitehead/manage_worker', $data);
			return;
		}

		// Get events for this project
		$eventModel = new EventModel();
		$events = $eventModel->where(['project_id' => $project->id]);
		$events = is_array($events) ? $events : []; // Convert false to empty array

		if (empty($events)) {
			$data = [
				'workers' => [],
				'error' => 'No events found for the ongoing project'
			];
			$this->view('sitehead/manage_worker', $data);
			return;
		}

		// Get worker events for these events
		$workerEventModel = new WorkerEventModel();
		$allWorkerEvents = [];

		// Loop through each event and get worker events
		foreach ($events as $event) {
			$workerEvents = $workerEventModel->where(['event_id' => $event->id]);
			$workerEvents = is_array($workerEvents) ? $workerEvents : []; // Convert false to empty array
			$allWorkerEvents = array_merge($allWorkerEvents, $workerEvents);
		}

		if (empty($allWorkerEvents)) {
			$data = [
				'workers' => [],
				'error' => 'No workers have applied to events in your project'
			];
			$this->view('sitehead/manage_worker', $data);
			return;
		}

		// Get unique worker IDs
		$workerIds = [];
		foreach ($allWorkerEvents as $we) {
			if (!in_array($we->worker_id, $workerIds)) {
				$workerIds[] = $we->worker_id;
			}
		}

		// Get worker details one by one
		$userModel = new User();
		$workers = [];
		foreach ($workerIds as $workerId) {
			$worker = $userModel->first([
				'id' => $workerId,
				'role_id' => 6
			]);
			if ($worker) {
				$workers[] = $worker;
			}
		}

		// Prepare worker details with their applied events
		$workerDetails = [];
		foreach ($workers as $worker) {
			$appliedEvents = [];

			// Find all events this worker applied to
			foreach ($allWorkerEvents as $we) {
				if ($we->worker_id == $worker->id) {
					$event = $eventModel->first(['id' => $we->event_id]);
					$event = $event ? $event : (object)['id' => 0, 'event_name' => 'Unknown', 'date' => '']; // Default empty event
					$appliedEvents[] = [
						'event_id' => $event->id,
						'event_name' => $event->event_name,
						'date' => $event->date,
						// 'status' => $we->status
					];
				}
			}

			$workerDetails[] = [
				'id' => $worker->id,
				'name' => $worker->name,
				'email' => $worker->email,
				'phone' => $worker->phone
			];
		}

		$data = [
			'workers' => $workerDetails,
			'project' => $project
		];

		$this->view('sitehead/manage_worker', $data);
	}

	public function approve_event($workerId, $eventId)
	{
		$workerEventModel = new WorkerEventModel();

		// Update status to approved
		if ($workerEventModel->updateStatus($workerId, $eventId, 'approved')) {
			// Success
			header('Location: ' . URLROOT . '/manage_worker');
		} else {
			// Error
			die('Something went wrong');
		}
	}

	// Helper method to simulate whereIn functionality if not in your Model trait
	private function whereIn($column, $values, $roleColumn = null, $roleValue = null)
	{
		$placeholders = implode(',', array_fill(0, count($values), '?'));
		$query = "SELECT * FROM users WHERE $column IN ($placeholders)";

		if ($roleColumn && $roleValue) {
			$query .= " AND $roleColumn = ?";
			$values[] = $roleValue;
		}

		$userModel = new User();
		return $userModel->query($query, $values);
	}
}
