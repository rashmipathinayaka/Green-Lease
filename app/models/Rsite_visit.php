<?php

class Rsite_visit
{
    use Model; // Using the Model trait

    protected $table = 'site_visit'; // Table name
    protected $allowedColumns = [
        'id', 
        'supervisor_id', 
        'land_id', 
        'date',
        're_date',
        'description'
    ]; // Allowed columns for insert/update

    // Method to insert data
    public function insertdata($formdata)
    {
        // Validate the incoming data before insertion
        if (!$this->validate($formdata)) {
            return $this->errors; // Return validation errors if any
        }

        // Insert the data using the insert method from the Model trait
        return $this->insert($formdata); // This will insert the data into the site_visit table
    }

    // Validation method (already shared)
    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['supervisor_id'])) {
            $this->errors['supervisor_id'] = "Supervisor ID is required";
        }

        if (empty($data['date'])) {
            $this->errors['date'] = "Date is required";
        }

        return empty($this->errors); // Returns true if no errors
    }

    public function getAllSiteVisits() {
        $query = "SELECT * FROM site_visit";
        return $this->query($query);  // or $this->run($query) if you're using a different DB wrapper
    }
    





    
}