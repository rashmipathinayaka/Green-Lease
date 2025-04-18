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

    public function removeBid($id)
{
    // Make sure the model is instantiated
    $bid = new SBid(); // Instantiating the SBid model
    
    if ($bid->delete($id)) {
        // Fetch updated bids for the buyer and reload the page
        $buyer_id = $_SESSION['id'];
        $bids = $bid->getBidsByBuyer($buyer_id);
        $this->view('buyer/Manage_bids', ['bids' => $bids]);
    } else {
        // If deletion fails, show a 404 page or an error message
        $this->view('_404');
    }
}



}
