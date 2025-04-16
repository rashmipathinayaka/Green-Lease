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

    //get sitevisit which are not rescheduled or not approved(status=0)
    public function getAllSiteVisits($id) {
        $query = "
            SELECT sv.*, l.address AS address
            FROM site_visit sv
            JOIN land l ON sv.land_id = l.id 
            WHERE sv.status='0' AND sv.supervisor_id = :id  ORDER BY sv.date ASC
        ";
        $data = [':id' => $id];
        return $this->query($query,$data);
        
    }
    






    public function updateVisitSchedule($visitId, $datetime)
    {
        // Corrected query
        $query = "UPDATE site_visit SET re_date = :datetime, status = '1' WHERE id = :visitId";
        
        return $this->query($query, [
            ':datetime' => $datetime,
            ':visitId' => $visitId
        ]);
    }
    


//supervisor direct approve the schedule visit
    public function insertApproval($id) {
        // First, we fetch the current date from the site_visit table based on the visit ID.
        $query = "SELECT `date` FROM site_visit WHERE id = :id";
        $result = $this->query($query, ['id' => $id]);
    
        // Check if the result is not empty
        if (!empty($result)) {
            $date = $result[0]->date; // Assuming result is an array of objects
    
            // Now, we perform the update query to set the status to 1 and insert the date into redate
            $queryUpdate = "UPDATE site_visit 
                            SET status = 1, re_date = :date 
                            WHERE id = :id";
    
            return $this->query($queryUpdate, [
                ':date' => $date,
                ':id' => $id
            ]);
        } else {
            // Handle case where no visit is found with the given ID
            return false;
        }
    }
    

    //to get approved site-visits

    public function getAllapprovedSiteVisits($id) {
        $query = "
        SELECT sv.*, l.address AS address
        FROM site_visit sv
        JOIN land l ON sv.land_id = l.id 
        WHERE sv.status='1' AND sv.supervisor_id = :id
        AND sv.date >= CURDATE()
        ORDER BY sv.date ASC
    ";
    
        $data = [':id' => $id];
        return $this->query($query,$data);
        
    }
    


    
}