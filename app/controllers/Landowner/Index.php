<?php 

/**
 * home class
 */
class Index
{
	use Controller;
	private $lands;

    public function __construct() {
        // Initialize the Land model in the constructor
        $this->lands = new RLand();
    }


	public function index()
	{
		
		$userId = $_SESSION['id'] ?? null; // Change this based on your authentication system
	
		if ($userId) {
			// Get land count for the logged-in user
			$landCount = $this->lands->countLandsByUserId($userId);
		} else {
			$landCount = 0; // Default value if user is not logged in
		}


		// $this->view('landowner/index', ['landCount' => $landCount]);	
	
	
	
	
		if ($userId) {
			// Get land count for the logged-in user
			$proCount = $this->lands->countProjectsByUserId($userId);
		} else {
			$proCount = 0; // Default value if user is not logged in
		}



	
		if ($userId) {
			// Get land count for the logged-in user
			$completedproCount = $this->lands->countcompletedProjectsByUserId($userId);
		} else {
			$completedproCount = 0; // Default value if user is not logged in
		}

		if ($userId) {
			// Get land count for the logged-in user
			$inactivelandsCount = $this->lands->countinactivelandsByUserId($userId);
		} else {
			$inactivelandsCount = 0; // Default value if user is not logged in
		}


		$lands = $this->lands->findOngoingprojects($userId);
		$landz = $this->lands->findCompletedprojects($userId);

	
		$this->view('landowner/index', ['landCount' => $landCount, 'proCount' => $proCount, 'completedproCount'=>$completedproCount,    'inactivelandsCount'=>$inactivelandsCount,
					'lands'=> $lands, 'landz'=>$landz]);

	
	}

}
