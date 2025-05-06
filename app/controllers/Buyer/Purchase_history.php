<?php 
/**
 * home class
 */
class Purchase_history
{
    use Controller;

    public function index()
    {
        if(!isset($_SESSION['id'])) {
            header("Location: " . URLROOT . "/login");
            exit();
        }
        
        $buyer_id = $_SESSION['id'];

        $purchase = new Purchase();

        $query = "SELECT p.*, b.buyer_id, u.full_name as buyer_name, u.contact_no, l.address as land_address, l.crop_type 
                 FROM purchase p 
                 JOIN bid b ON p.bid_id = b.id
                 JOIN user u ON b.buyer_id = u.id 
                 JOIN harvest h ON b.harvest_id = h.id 
                 JOIN project pr ON h.project_id = pr.id
                 JOIN land l ON pr.land_id = l.id 
                 WHERE b.buyer_id = :buyer_id";
        
        $data['purchases'] = $purchase->query($query, ['buyer_id' => $buyer_id]);
        
        $this->view('Buyer/Purchase_history', $data);
    }

    public function submit_rating()
    {
        header('Content-Type: application/json');

        if(!isset($_SESSION['id'])) {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            return;
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json);

        if (!$data || !isset($data->purchase_id) || !isset($data->rating)) {
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
            return;
        }

        $rating = floatval($data->rating);
        if ($rating < 1 || $rating > 5) {
            echo json_encode(['success' => false, 'message' => 'Invalid rating value']);
            return;
        }

        $feedback = isset($data->feedback) ? trim($data->feedback) : null;

        $purchase = new Purchase();

        $query = "SELECT p.* FROM purchase p
                  JOIN bid b ON p.bid_id = b.id
                  WHERE p.id = :purchase_id AND b.buyer_id = :buyer_id AND p.status = 'Delivered' AND p.rating IS NULL";
        $result = $purchase->query($query, [
            'purchase_id' => $data->purchase_id,
            'buyer_id' => $_SESSION['id']
        ]);

        if (empty($result)) {
            echo json_encode(['success' => false, 'message' => 'Invalid purchase or already rated']);
            return;
        }

        try {

            $updateQuery = "UPDATE purchase SET rating = :rating, feedback = :feedback WHERE id = :purchase_id";
            $purchase->query($updateQuery, [
                'rating' => $rating,
                'feedback' => $feedback,
                'purchase_id' => $data->purchase_id
            ]);

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