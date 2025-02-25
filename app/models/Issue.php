<?php

class Issue
{
    use Model;

    protected $table = 'issues';

    protected $allowedColumns = [
        'name',
        'complaint_type',
        'description',
        'attachment',
        'status',
        'created_at',
    ];

    public function validate($data)
    {
        $this->errors = [];

        // Validate name
        if (empty($data['name'])) {
            $this->errors['name'] = 'Name is required.';
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
