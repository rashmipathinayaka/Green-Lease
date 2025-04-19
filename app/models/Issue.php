<?php

class Issue
{
    use Model;

    protected $table = 'issue';

    protected $allowedColumns = [
        'sitehead_id',
        'complaint_type',
        'description',
        'attachment',
        'status',
        'feedback'
    ];

    public function validate($data)
    {
        $this->errors = [];

        // Validate name
        if (empty($data['sitehead_id'])) {
            $this->errors['sitehead_id'] = 'Sitehead_ID is required.';
        }

        // Validate complaint type
        if (empty($data['complaint_type'])) {
            $this->errors['complaint_type'] = 'Complaint type is required.';
        }

        // Validate description
        if (empty($data['description'])) {
            $this->errors['description'] = 'Description is required.';
        }

        // Validate attachment (optional)
        if (!empty($data['attachment']['name'])) {
            $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
            if (!in_array($data['attachment']['type'], $allowedTypes)) {
                $this->errors['attachment'] = 'Invalid file type. Allowed: PDF, JPG, PNG.';
            }
            if ($data['attachment']['size'] > 5 * 1024 * 1024) { // 5MB max
                $this->errors['attachment'] = 'File size exceeds 5MB.';
            }
        }

        return empty($this->errors);
    }
}
