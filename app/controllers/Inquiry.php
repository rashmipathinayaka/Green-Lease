<?php

class Inquiry
{
    use Controller;
    public function index($a = '', $b = '', $c = '')
    {
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
            $formData = [
                'name' => $_POST['name'] ?? null,
                'email' => $_POST['email'] ?? null,
                'subject' => $_POST['subject'] ?? null,
                'message' => $_POST['message'] ?? null,
                'is_resolved' => 0,
                'is_deleted' => 0
            ];

            if ($inquiryModel->validate($formData)) {
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

        if (!empty($data['errors']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view('contact', $data);
        } else {
            header('Location:' . URLROOT . '/home');
            exit();
        }
    }

    public function markAsSolved($id)
    {
        $inquiryModel = new InquiryModel();

        if (!$inquiryModel->update($id, ['is_solved' => 1], 'id')) {
            header('Location: ' . URLROOT . '/Admin');
        } else {
            $this->view('_404');
        }
    }

    public function deleteInquiry($id)
    {

        $inquiryModel = new InquiryModel();  
        if (!$inquiryModel->delete($id)) {
            header('Location:' . URLROOT . '/admin');
            exit();
        } else {
            $this->view('_404');
        }
    }
}
