<?php

class Inquiry
{
    use Controller;
    public function index($a = '', $b = '', $c = '')
    {
        // Ensure session_start() is called first
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Check if the user is logged in
        if (!isset($_SESSION['id'])) {
            header("Location: " . URLROOT . "/unauthorized");
            exit();
        }

        // Load the view for inquiries (if required)
        $this->view('inquiry');
    }

    public function addInquiry()
    {

        $inquiryModel = new InquiryModel();  // Using InquiryModel for the model
        $data = [
            'errors' => [], // Initialize errors
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Capture form data
            $formData = [
                'name' => $_POST['name'] ?? null,
                'email' => $_POST['email'] ?? null,
                'subject' => $_POST['subject'],
                'message' => $_POST['message'] ?? null,
            ];

            // Validate data
            if ($inquiryModel->validate($formData)) {
                // Insert data into the inquiry table
                $inquiryModel->insert($formData);
            } else {
                echo "Data insertion failed.";
            }
        }

        // Redirect back to the landing page or wherever necessary
        header('Location:' . URLROOT . '/home');
    }

    public function markAsSolved($id)
    {
        // Update the status of the issue to 'solved'
        $inquiryModel = new InquiryModel();

        if (!$inquiryModel->update($id, ['is_solved' => 1], 'id')) {
            // Redirect back to the Manage Issues page
            // $this->view('/Supervisor/ManageIssues');
            header('Location: ' . URLROOT . '/Admin');
        } else {
            // Show an error page if the update fails
            $this->view('_404');
        }
    }

    public function deleteInquiry($id)
    {

        $inquiryModel = new InquiryModel();  // Using InquiryModel for the model
        if (!$inquiryModel->delete($id)) {
            header('Location:' . URLROOT . '/admin');
            exit();
        } else {
            // If deletion fails, show a 404 page or an error message
            $this->view('_404');
        }
    }
}
