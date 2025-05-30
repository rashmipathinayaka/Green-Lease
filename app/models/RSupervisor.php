<?php

class RSupervisor
{
    use Model;

    protected $table = 'supervisor';

    protected $allowedColumns = [
       'id',
       'zone',
       'status',
       'user_id'
       
    ];




    public function validate($data)
	{
		$this->errors = [];

		if (empty($data['zone'])) {
			$this->errors['zone'] = " zone is required";
		}

		if (empty($data['status'])) {
			$this->errors['status'] = "status is required";
		}

		if (empty($this->errors)) {
			return true;
		}

		return false;
	}


public function getlandzone($id)
{
    $query = 'SELECT zone FROM land WHERE id = :id';
    $result = $this->query($query, ['id' => $id]);

    if ($result && isset($result[0])) {
        return $result[0]->zone;  
    }

    return false;  
}




public function getAllSupervisorslessthanmaxcount($procount, $landzone) {
    $query = "
        SELECT s.id AS id, COUNT(p.id) AS procount
        FROM supervisor s
        LEFT JOIN project p ON s.id = p.supervisor_id
        LEFT JOIN land l ON s.zone = l.zone
        WHERE l.zone = :landzone
        GROUP BY s.id
        HAVING COUNT(p.id) < :procount
    ";

    
    return $this->query($query, [
        ':landzone' => $landzone,
        ':procount' => $procount
    ]);
}



    public function getEmailById($supervisorId)
    {
        $query = "SELECT user.email 
                  FROM supervisor 
                  JOIN user ON user.id = supervisor.user_id 
                  WHERE supervisor.id = :id";
    
        $data = [':id' => $supervisorId];
    
        $result = $this->query($query, $data);
        return $result[0]->email ?? null; 
    }
   
   


    public function getSupervisorDetails($filters = []) {
        $query = '
            SELECT s.*, u.full_name, u.email, u.contact_no,u.propic, u.joined_date, 
                   COUNT(p.id) AS land_count, z.zone_name
            FROM supervisor s 
            JOIN user u ON s.user_id = u.id
            LEFT JOIN project p ON s.id = p.supervisor_id
            LEFT JOIN zone z ON s.zone = z.id
            WHERE 1=1
        ';
        
    
        $params = [];
    
        if (!empty($filters['full_name'])) {
            $query .= " AND LOWER(u.full_name) LIKE ?";
            $params[] =  strtolower($filters['full_name']) . "%";
        }
        
        if (!empty($filters['zone'])) {
            $query .= " AND s.zone = ?";
            $params[] = $filters['zone'];
        }
    
        $query .= " GROUP BY s.id";
    
        return $this->query($query, $params);
    }
    
    

    public function countsupervisors()
	{

		$query = "SELECT COUNT(*) FROM supervisor ";

	
		$result = $this->query($query);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  
	}
    
       
    
       








      
    public function getSupervisorbyid($id) {
        $query = 'SELECT s.*, u.full_name, u.email, u.contact_no,u.joined_date,u.nic
                  FROM supervisor s
                  JOIN user u ON s.user_id = u.id
                  WHERE s.id = :id'; // Use supervisor's id here to get the correct supervisor
        $data = [':id' => $id]; // Bind the id parameter
    
        // Assuming query() returns an array of results
        $result = $this->query($query, $data);
        
        // Return the first result or null if not found
        return $result ? $result[0] : null;
    }
    
    
 



}