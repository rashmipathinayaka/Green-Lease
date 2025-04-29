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
			'todaysEvents' => [],
			'notifications' => []
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
				// Get ongoing project ID of the sitehead
				$projectModel = new Project();

				$project = $projectModel->first([
					'sitehead_id' => $siteheadData->id,
					'status' => 'ongoing'
				]);

				// Get today's events if we have projects
				if ($project !== false) {
					$eventModel = new EventModel();
					$data['todaysEvents'] = $eventModel->getTodaysEvents($project->id);
				}
			}

			$data['sname'] = $userData->full_name;
			$data['project'] = $project;

			// // Get upcoming events count (implement your logic)
			$data['upcomingEventsCount'] = $eventModel->getUpcomingEventsCount($project->id);

			//Get notifications for the sitehead
			if ($userData && $userData->role_id == 3) { // 3 = Sitehead
				$notificationModel = new Notification();
				$data['notifications'] = $notificationModel->getForUser($userId, true);
			}
		}

		$this->view('sitehead/index', $data);
	}
}
