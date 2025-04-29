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

		// Get workers with their applied upcoming events
		$workerEventModel = new WorkerEventModel();
		$workers = $workerEventModel->getWorkersWithUpcomingEvents($project->id);

		$data = [
			'workers' => $workers,
			'project' => $project,
			'error' => empty($workers) ? 'No workers have applied to upcoming events in your project' : null
		];

		$this->view('sitehead/manage_worker', $data);
	}

	public function approve_event($workerId, $eventId)
	{
		$workerEventModel = new WorkerEventModel();

		// Update status to approved
		if ($workerEventModel->updateStatus($workerId, $eventId, 'Approved')) {
			// Success
			header('Location: ' . URLROOT . '/sitehead/manage_worker');
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
