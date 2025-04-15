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





//drop down in sitevisit
    public function getAllSupervisors() {
        $query = "SELECT id FROM supervisor"; // Adjust columns as needed
        return $this->query($query); 
    }

//to email supervisors
    public function getEmailById($supervisorId)
    {
        $query = "SELECT user.email 
                  FROM supervisor 
                  JOIN user ON user.id = supervisor.id 
                  WHERE supervisor.id = :id";
    
        $data = [':id' => $supervisorId];
    
        $result = $this->query($query, $data);
        return $result[0]->email ?? null; // return just the string
    }
   
    // public function getSupervisorDetails() {
    //     $user=new RUser;
    //     $query = 'SELECT s.*, u.full_name, u.email ,u.contact_no,u.joined_date
    //               FROM supervisor s 
    //               JOIN user u ON s.user_id = u.id';
    //     return $this->query($query);
        
    // }


    //for admin to filter supervisors
    public function getSupervisorDetails($filters = []) {
       
    
        $query = '
            SELECT s.*, u.full_name, u.email, u.contact_no, u.joined_date, 
                   COUNT(p.id) AS land_count
            FROM supervisor s 
            JOIN user u ON s.user_id = u.id
            LEFT JOIN project p ON s.id = p.supervisor_id
            WHERE 1=1
        ';
        
        $params = [];
    
        if (!empty($filters['full_name'])) {
            $query .= " AND u.full_name LIKE ?";
            $params[] =  $filters['full_name'] . "%";
        }
    
        if ($filters['zone'] !== '') {
            $query .= " AND s.zone = ?";
            $params[] = $filters['zone'];
        }
    
        $query .= " GROUP BY s.id";
    
        return $this->query($query, $params);
    }
    

    public function countsupervisors()
	{

		$query = "SELECT COUNT(*) FROM supervisor ";
		// Make sure 'userId' is passed correctly

		// Call query
		$result = $this->query($query);
		return $result ? (int) $result[0]->{'COUNT(*)'} : 0;  // Convert to integer
	}
    
       
    
       








      //to get profiles
    public function getSupervisorbyid($id) {
        $query = 'SELECT s.*, u.full_name, u.email, u.contact_no,u.joined_date
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