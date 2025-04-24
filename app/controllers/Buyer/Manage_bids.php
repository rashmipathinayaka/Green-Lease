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

		$this->view('buyer/Manage_bids', $data);
	}

    public function removeBid($id)
    {
        if(!isset($_SESSION['id'])) {
            header("Location: " . URLROOT . "/login");
            exit();
        }

        $bid = new SBid();
        
        // Get the bid to check ownership
        $bids = $bid->where(['id' => $id, 'buyer_id' => $_SESSION['id']]);
        if (empty($bids)) {
            $_SESSION['message'] = 'Bid not found or unauthorized';
            $_SESSION['message_type'] = 'error';
            header("Location: " . URLROOT . "/Buyer/Manage_bids");
            exit();
        }

        $current_bid = $bids[0];
        if ($current_bid->status !== 'Pending') {
            $_SESSION['message'] = 'Only pending bids can be removed';
            $_SESSION['message_type'] = 'error';
            header("Location: " . URLROOT . "/Buyer/Manage_bids");
            exit();
        }
        
        if ($bid->delete($id)) {
            $_SESSION['message'] = 'Bid removed successfully';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Failed to remove bid';
            $_SESSION['message_type'] = 'error';
        }
        
        header("Location: " . URLROOT . "/Buyer/Manage_bids");
        exit();
    }
}
