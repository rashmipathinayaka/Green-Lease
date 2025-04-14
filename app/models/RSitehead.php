<?php

class RSitehead
{
    use Model;

    protected $table = 'sitehead';

    protected $allowedColumns = [
       'id',
       'land_id',
       'status',
       'user_id'
       
    ];


    public function getSiteheadDetails($filters = []) {
        $query = '
        SELECT 
            s.*, 
            u.full_name, 
            u.email, 
            u.contact_no, 
            u.joined_date,
            l.address
        FROM sitehead s 
        JOIN user u ON s.user_id = u.id
        LEFT JOIN land l ON s.land_id = l.id
        WHERE 1=1
        ';
        
        $params = [];
    
        if (!empty($filters['full_name'])) {
            $query .= " AND u.full_name LIKE ?";
            $params[] = "%" . $filters['full_name'] . "%";
        }
    
        if (isset($filters['land_id']) && $filters['land_id'] !== '') {
            $land_id = (int)$filters['land_id'];
            $query .= " AND s.land_id = ?";
            $params[] = $land_id;
        }
    
        $query .= " GROUP BY s.id";
    
        // Debug output
        error_log("Final query: " . $query);
        error_log("Query params: " . print_r($params, true));
    
        return $this->query($query, $params);
    }


         //to get profiles
         public function getSiteheadbyid($id) {
            $query = 'SELECT s.*, u.full_name, u.email, u.contact_no,u.joined_date
                      FROM sitehead s
                      JOIN user u ON s.user_id = u.id
                      WHERE s.id = :id'; 
            $data = [':id' => $id]; // Bind the id parameter
        
            // Assuming query() returns an array of results
            $result = $this->query($query, $data);
            
            // Return the first result or null if not found
            return $result ? $result[0] : null;
        }
        
}