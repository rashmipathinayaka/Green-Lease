<?php 

/**
 * home class
 */
class Manage_bids
{
	use Controller;

	public function index()
	{
		if(!isset($_SESSION['id'])) {
            // Redirect to login page if user is not logged in
            header("Location: " . URLROOT . "/login");
            exit();
        }
        
        // Get the user ID from the session
        $buyer_id = $_SESSION['id'];

        $bids = new SBid();
        // Fetch purchases for the current buyer
        $data['bids'] = $bids->getBidsByBuyer($buyer_id);

		$this->view('buyer/Manage_bids', $data);;
	}

}
