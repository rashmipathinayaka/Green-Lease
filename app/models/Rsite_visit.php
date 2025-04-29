<?php

class Rsite_visit
{
    use Model; 

    protected $table = 'site_visit'; 
    protected $allowedColumns = [
        'id', 
        'supervisor_id', 
        'land_id', 
        'date',
        're_date',
        'from_date',
        'to_date',
        'description',
        'email_flag',
    ]; 

    
    public function insertdata($formdata)
    {
        if (!$this->validate($formdata)) {
            return $this->errors; 
        }

        return $this->insert($formdata); 
    }

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['supervisor_id'])) {
            $this->errors['supervisor_id'] = "Supervisor ID is required";
        }

        if (empty($data['date'])) {
            $this->errors['date'] = "Date is required";
        }

        return empty($this->errors); 
    }

    public function getAllSiteVisits($id) {
        $query = "SELECT sv.*, l.address AS address
FROM site_visit sv
JOIN land l ON sv.land_id = l.id
JOIN supervisor s ON sv.supervisor_id = s.id
WHERE sv.status = '0' AND s.user_id = :id
ORDER BY sv.date ASC";

        $data = [':id' => $id];
        return $this->query($query,$data);
        
    }
    






    public function updateVisitSchedule($visitId, $datetime)
    {
        $query = "UPDATE site_visit SET re_date = :datetime, status = '1' WHERE id = :visitId";
        
        return $this->query($query, [
            ':datetime' => $datetime,
            ':visitId' => $visitId
        ]);
    }
    


    public function supervisorreshedulekrpuwapennan(){
        $query="SELECT sv.*, l.address AS address
FROM site_visit sv
JOIN land l ON sv.land_id = l.id
WHERE sv.status = '1';
";
        return $this->query($query);
    }

    public function insertApproval($id) {
        $query = "SELECT `date` FROM site_visit WHERE id = :id";
        $result = $this->query($query, ['id' => $id]);
    
        if (!empty($result)) {
            $date = $result[0]->date; 
    
            $queryUpdate = "UPDATE site_visit 
                            SET status = 1, re_date = :date 
                            WHERE id = :id";
    
            return $this->query($queryUpdate, [
                ':date' => $date,
                ':id' => $id
            ]);
        } else {
            return false;
        }
    }
    


    public function getAllapprovedSiteVisits($id) {

        //meka hari
        $query = "
            SELECT sv.*, l.address, l.id as land_id, l.crop_type AS crop_type
            FROM site_visit sv
            JOIN land l ON sv.land_id = l.id
            LEFT JOIN project p ON l.id = p.land_id  -- Joining the project table
            WHERE sv.status = '1' 
              AND sv.supervisor_id = :id
              AND sv.re_date >= CURDATE()
              AND (p.status != 'Pending' OR p.status IS NULL)  -- Excluding 'Pending' projects
            ORDER BY sv.date ASC
        ";
    
        
    //     $query = "
    //     SELECT sv.*, l.address, l.id as land_id, l.crop_type AS crop_type
    //     FROM site_visit sv
    //     JOIN land l ON sv.land_id = l.id
    //     LEFT JOIN project p ON l.id = p.land_id  -- Joining the project table
    //     WHERE sv.status = '1' 
    //       AND sv.supervisor_id = :id
    //       AND sv.re_date >= CURDATE()
    //       AND (p.status != 'Pending' OR p.status IS NULL)  -- Excluding 'Pending' projects
    //       AND sv.outcome IS NULL  -- Only including rows where outcome is NULL
    //     ORDER BY sv.date ASC
    // ";

    
    
    //     $query = "
    //     SELECT sv.*, l.address, l.id as land_id, l.crop_type AS crop_type
    //     FROM site_visit sv
    //     JOIN land l ON sv.land_id = l.id
    //     LEFT JOIN project p ON l.id = p.land_id  -- Joining the project table
    //     WHERE sv.status = '1' 
    //       AND sv.supervisor_id = :id
    //       AND sv.re_date >= CURDATE()
    //       AND (p.status != 'Pending' OR p.status IS NULL)  -- Excluding 'Pending' projects
    //       AND sv.outcome != 'Rejected'  -- Excluding rejected outcomes
    //     ORDER BY sv.date ASC
    // ";
    
    
        $data = [':id' => $id];
        return $this->query($query,$data);
        
    }
    
public function getallapprovedvisits() {
    $query = "
        SELECT sv.*, l.address AS address
        FROM site_visit sv
        JOIN land l ON sv.land_id = l.id 
        WHERE sv.status = '1' 
        AND sv.re_date >= CURDATE() 
        AND sv.email_flag = '0'
        ORDER BY sv.date ASC
    ";

    return $this->query($query);
}


    
    




public function getVisitById($visit_id) {
    $query = "
        SELECT 
            sv.*, 
            l.landowner_id 
        FROM site_visit sv 
        JOIN land l ON sv.land_id = l.id 
        WHERE sv.id = :id
    ";

    $data = [':id' => $visit_id];
    return $this->query($query, $data)[0] ?? null;
}

public function emailupdate($id) {
    $query = "UPDATE site_visit SET email_flag = '1' WHERE id = :id";
    $data = [':id' => $id];
    return $this->query($query, $data);
}


public function getdaterange($land_id){
    $query = "SELECT from_date, to_date FROM site_visit WHERE land_id = :land_id";
    $data = [':land_id' => $land_id];
    $result = $this->query($query, $data);

    if (!empty($result)) {
        return [
            'from_date' => $result[0]->from_date,
            'to_date' => $result[0]->to_date
        ];
    }

    return null;

}





public function insertsupervisor($formdata) {
    $query = "UPDATE site_visit 
        SET supervisor_id = :supervisor_id 
        WHERE land_id = :land_id
    ";

    $data = [
        'supervisor_id' => $formdata['supervisor_id'],
        'land_id' => $formdata['land_id']
    ];

    return $this->query($query, $data);


}


public function getlandid($id){

 $query="SELECT land_id from site_visit where id=:id";

return $this->query($query);

}



    
}