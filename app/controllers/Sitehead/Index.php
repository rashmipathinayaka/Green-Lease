<?php

/**
 * home class
 */
class Index
{
	use Controller;

	public function index()
	{
		// Initialize with empty array to prevent foreach errors
		$data = [
			'todaysEvents' => []
			// 'workerCount' => 0,
			// 'upcomingEventsCount' => 0
		];

		// Only proceed if user is logged in
		if (isset($_SESSION['id'])) {
			$userId = $_SESSION['id'];
			// $userName = $_SESSION['name'];
			$userModel = new User();
			$userData = $userModel->first(['id' => $userId]);

			// Get sitehead's data
			$siteheadModel = new Sitehead();
			$siteheadData = $siteheadModel->first(['user_id' => $userId]);

			if (!empty($siteheadData)) {
				// Get project IDs of the sitehead
				$projectModel = new Project();
				$projectIds = [];

				$projects = $projectModel->where([
					'sitehead_id' => $siteheadData->id,
					'status' => 'ongoing'
				]);

				foreach ($projects as $project) {
					$projectIds[] = $project->id;
				}

				// Get today's events if we have projects
				if (!empty($projectIds)) {
					$eventModel = new EventModel();
					$data['todaysEvents'] = $eventModel->getTodaysEvents($projectIds);
				}
			}

			$data['sname'] = $userData->full_name;

			// // Get upcoming events count (implement your logic)
			// $data['upcomingEventsCount'] = $this->getUpcomingEventsCount($userId);
		}

		$this->view('sitehead/index', $data);
	}
}
