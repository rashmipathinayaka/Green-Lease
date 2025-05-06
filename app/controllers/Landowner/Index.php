<?php 

/**
 * home class
 */
class Index
{
	use Controller;
	private $lands;
	private $landowner;

    public function __construct() {
        $this->lands = new RLand();
$this->landowner = new RUser();
    }


	public function index()
	{
		
		$userId = $_SESSION['id'] ?? null;

		if ($userId) {
			$landCount = $this->lands->countLandsByUserId($userId);
		} else {
			$landCount = 0; 
		}	
	
	
	
		if ($userId) {
			$proCount = $this->lands->countProjectsByUserId($userId);
		} else {
			$proCount = 0; 
		}



	
		if ($userId) {
			$completedproCount = $this->lands->countcompletedProjectsByUserId($userId);
		} else {
			$completedproCount = 0; 
		}

		if ($userId) {
			$inactivelandsCount = $this->lands->countinactivelandsByUserId($userId);
		} else {
			$inactivelandsCount = 0; 
		}


		$lands = $this->lands->findOngoingprojects($userId);
		$landz = $this->lands->findCompletedprojects($userId);
		$user=$this->landowner->getuserinfobyid($userId);
	
		$this->view('landowner/index', ['landCount' => $landCount, 'proCount' => $proCount, 'completedproCount'=>$completedproCount,
		 'inactivelandsCount'=>$inactivelandsCount,
					'lands'=> $lands, 'landz'=>$landz, 'user'=>$user]);

	
	}

}
