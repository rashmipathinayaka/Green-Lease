<?php 

/**
 * home class
 */
class Index
{
	
	use Controller;
	private $lands;
private $bids;


	public function __construct() {
        // Initialize the Land model in the constructor
        $this->lands = new Land();

		$this->bids = new Bid();

    }


	

	public function index()
	{
		
		//$userId = $_SESSION['user_id'] ?? null; // Change this based on your authentication system

$userId=19;
		if ($userId) {
			// Get land count for the logged-in user
			$landCount = $this->lands->countLands();
		} else {
			$landCount = 0; // Default value if user is not logged in
		}


		if ($userId) {
			// Get land count for the logged-in user
			$bidCount = $this->bids->countbids();
		} else {
			$bidCount = 0; // Default value if user is not logged in
		}





		$this->view('admin/Index',['landCount'=>$landCount,  'bidCount'=>$bidCount]);
	}

}
