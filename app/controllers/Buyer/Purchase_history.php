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
        // Updated JOIN query to use project table as the connection
        $query = "SELECT p.*, u.full_name as buyer_name, u.contact_no, l.address as land_address, l.crop_type 
                 FROM purchase p 
                 JOIN user u ON p.buyer_id = u.id 
                 JOIN harvest h ON p.harvest_id = h.id 
                 JOIN project pr ON h.project_id = pr.id
                 JOIN land l ON pr.land_id = l.id 
                 WHERE p.buyer_id = :buyer_id";
        
        $data['purchases'] = $purchase->query($query, ['buyer_id' => $buyer_id]);
        
        $this->view('Buyer/Purchase_history', $data);
    }

    public function submit_rating()
    {
        header('Content-Type: application/json');

        // Check if user is logged in
        if(!isset($_SESSION['id'])) {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            return;
        }

        // Get JSON data from request body
        $json = file_get_contents('php://input');
        $data = json_decode($json);

        if (!$data || !isset($data->purchase_id) || !isset($data->rating)) {
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
            return;
        }

        // Validate rating value
        $rating = floatval($data->rating);
        if ($rating < 1 || $rating > 5) {
            echo json_encode(['success' => false, 'message' => 'Invalid rating value']);
            return;
        }

        $purchase = new Purchase();
        
        // Verify the purchase belongs to the logged-in user and is in 'Delivered' status
        $query = "SELECT * FROM purchase WHERE id = :purchase_id AND buyer_id = :buyer_id AND status = 'Delivered' AND rating IS NULL";
        $result = $purchase->query($query, [
            'purchase_id' => $data->purchase_id,
            'buyer_id' => $_SESSION['id']
        ]);

        if (empty($result)) {
            echo json_encode(['success' => false, 'message' => 'Invalid purchase or already rated']);
            return;
        }

        try {
            // Update the rating using direct query
            $updateQuery = "UPDATE purchase SET rating = :rating WHERE id = :purchase_id";
            $purchase->query($updateQuery, [
                'rating' => $rating,
                'purchase_id' => $data->purchase_id
            ]);

            // Verify if the update was successful by checking if the rating was actually set
            $verifyQuery = "SELECT rating FROM purchase WHERE id = :purchase_id";
            $verifyResult = $purchase->query($verifyQuery, ['purchase_id' => $data->purchase_id]);

            if ($verifyResult && isset($verifyResult[0]->rating) && $verifyResult[0]->rating == $rating) {
                echo json_encode(['success' => true, 'message' => 'Rating submitted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to verify rating update']);
            }
        } catch (Exception $e) {
            error_log("Error updating rating: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'An error occurred while updating the rating']);
        }
    }
}