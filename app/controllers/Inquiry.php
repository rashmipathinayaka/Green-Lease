<?php

class Inquiry
{
    use Controller;
    public function index($a = '', $b = '', $c = '')
    {
        // Load the view for inquiries
        $this->view('inquiry');
    }

    public function addInquiry()
    {
        $inquiryModel = new InquiryModel();
        $data = [
            'errors' => [],
            'success' => false
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Capture form data
            $formData = [
                'name' => $_POST['name'] ?? null,
                'email' => $_POST['email'] ?? null,
                'subject' => $_POST['subject'] ?? null,
                'message' => $_POST['message'] ?? null,
                'is_resolved' => 0,
                'is_deleted' => 0
            ];

            // Validate data
            if ($inquiryModel->validate($formData)) {
                // Insert data into the inquiry table
                if ($inquiryModel->insert($formData)) {
                    $data['success'] = true;
                    $_SESSION['success_message'] = "Your inquiry has been submitted successfully!";
                } else {
                    $data['errors']['submit'] = "Failed to submit inquiry. Please try again.";
                }
            } else {
                $data['errors'] = $inquiryModel->errors;
            }
        }

        // If there are errors or it's not a POST request, show the contact page
        if (!empty($data['errors']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view('contact', $data);
        } else {
            // Redirect to home page on success
            header('Location:' . URLROOT . '/home');
            exit();
        }
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
