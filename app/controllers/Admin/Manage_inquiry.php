<?php

class Manage_inquiry
{
    use Controller;
    private $inquiryModel;

    public function __construct()
    {
        $this->inquiryModel = new RInquiry();
    }

    public function index()
    {
        $inquiries = $this->inquiryModel->getAllunsoledInquiries(); 
        $this->view('admin/manage_inquiry', ['inquiries' => $inquiries]); 
    }

public function solved($id)
    {
        $this->inquiryModel->markassolved($id);
        header('Location: ' . URLROOT . '/admin/manage_inquiry');
        exit;
    }

    public function delete($id)
    {
        $this->inquiryModel->markasdeleted(['id' => $id]);
        header('Location: ' . URLROOT . '/admin/manage_inquiry');
        exit;
    }






}
