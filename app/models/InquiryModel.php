<?php

class InquiryModel
{
    use Model; // Use the Model trait to inherit insert functionality

    protected $table = 'inquiries';

    protected $allowedColumns = [
        'name',
        'email',
        'subject',
        'message',
        'is_resolved',  // Add any other fields if needed
        'is_deleted',
    ];

    public function validate($data)
    {
        $this->errors = [];

        // Simple validation
        if (empty($data['name'])) {
            $this->errors['name'] = "Name is required";
        }

        if (empty($data['email'])) {
            $this->errors['email'] = "Email is required";
        }

        if (empty($data['subject'])) {
            $this->errors['subject'] = "Subject is required";
        }

        if (empty($data['message'])) {
            $this->errors['message'] = "Message is required";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
