<?php 
/**
 * home class
 */
class Purchase_history
{
    use Controller;

    public function index()
    {
        // Check if user is logged in
        if(!isset($_SESSION['id'])) {
            // Redirect to login page if user is not logged in
            header("Location: " . URLROOT . "/login");
            exit();
        }
        
        // Get the user ID from the session
        $buyer_id = $_SESSION['id'];

        $purchase = new Purchase();
        // Fetch purchases for the current buyer
        $data['purchases'] = $purchase->where(['buyer_id' => $buyer_id]);
        
        $this->view('Buyer/Purchase_history', $data);
    }
}