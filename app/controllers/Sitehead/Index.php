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

			// Get sitehead's data
			$siteheadModel = new Sitehead();
			$siteheadData = $siteheadModel->where(['user_id' => $userId]);

			if (!empty($siteheadData)) {
				// Get project IDs of the sitehead
				$projectModel = new Project();
				$projectIds = [];

				foreach ($siteheadData as $sdata) {
					$projects = $projectModel->where(['land_id' => $sdata->land_id]);
					foreach ($projects as $project) {
						$projectIds[] = $project->id;
					}
				}

				// Get today's events if we have projects
				if (!empty($projectIds)) {
					$eventModel = new EventModel();
					$data['todaysEvents'] = $eventModel->getTodaysEvents($projectIds);
				}
			}

			// // Get worker count (implement your logic)
			// $data['workerCount'] = $this->getWorkerCount($userId);

			// // Get upcoming events count (implement your logic)
			// $data['upcomingEventsCount'] = $this->getUpcomingEventsCount($userId);
		}

		$this->view('sitehead/index', $data);
	}
}
