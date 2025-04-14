<?php

class RProject
{
    use Model;

    protected $table = 'projects';  // Table name 'projects'

    protected $allowedColumns = [
       'id',
       'supervisor_id',
       'land_id',  // Ensure correct column naming
       'duration',
    ];

    // Method to count the number of projects for a given supervisor
    public function projectspersupervisor($supervisorId) {
        // Query to count the number of projects for a given supervisor
        $query = "SELECT COUNT(*) AS project_count FROM project WHERE supervisor_id = :supervisor_id";

        // Prepare data for binding
        $data = [':supervisor_id' => $supervisorId];
        
        // Call bind method for the query
        $this->bind($query, ':supervisor_id', $supervisorId);

        // Call the single method to execute the query and get the result
        $result = $this->single($query, $data);
        
        return $result;  // Return the result object
    }
}
