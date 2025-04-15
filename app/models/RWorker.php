<?php

class RWorker
{
    use Model;

    protected $table = 'user';

    protected $allowedColumns = [
        'password',
        'email',
        'role_id',
        'nic',
        'contact_no',
        'full_name',
        'id',
        'joined_date',
    ];


    public function getworkerdetails($filters = []) {
        $query = 'SELECT 
                    u.*, 
                    COUNT(we.event_id) AS no_events
                  FROM 
                    user u
                  LEFT JOIN 
                    worker_event we ON u.id = we.worker_id
                  WHERE 
                    u.role_id = 6';
        
        $params = [];
        
        if (!empty($filters['full_name'])) {
            $query .= " AND u.full_name LIKE ?";
            $params[] = $filters['full_name'] . "%";  // Removed leading % to match only names starting with
        }
        
        $query .= " GROUP BY u.id";
        
        try {
            return $this->query($query, $params) ?: [];
        } catch (Exception $e) {
            error_log("Worker details query failed: " . $e->getMessage());
            return [];
        }
    }

    public function getWorkerbyid($id) {
        $query = 'SELECT * from user where id = :id'; 
        $data = [':id' => $id]; // Bind the id parameter
    
        // Assuming query() returns an array of results
        $result = $this->query($query, $data);
        
        // Return the first result or null if not found
        return $result ? $result[0] : null;
    }
    



}






