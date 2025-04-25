<?php

class Manage_inquiry
{
    use Controller;
    private $inquiryModel;

    public function __construct()
    {
        $this->inquiryModel = new RInquiry(); // Assuming you have an InquiryModel class for handling inquiries
    }

    public function index()
    {
        $inquiries = $this->inquiryModel->getAllunsoledInquiries(); // Fetch all inquiries from the model
        $this->view('admin/manage_inquiry', ['inquiries' => $inquiries]); // Pass the inquiries to the view
    }

public function solved($id)
    {
        // Mark the inquiry as solved
        $this->inquiryModel->markassolved($id);
        // Redirect back to the inquiries page
        header('Location: ' . URLROOT . '/admin/manage_inquiry');
        exit;
    }

    public function delete($id)
    {
        // Delete the inquiry
        $this->inquiryModel->markasdeleted(['id' => $id]);
        // Redirect back to the inquiries page
        header('Location: ' . URLROOT . '/admin/manage_inquiry');
        exit;
    }






}
