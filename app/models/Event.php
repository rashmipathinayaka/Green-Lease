<?php
class Event {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Get events for a project
    public function getEventsByProject($projectId) {
        $this->db->query('SELECT * FROM event WHERE project_id = :project_id ORDER BY date ASC, time ASC');
        $this->db->bind(':project_id', $projectId, PDO::PARAM_STR);
        
        return $this->db->resultSet();
    }

    // Add new event
    public function addEvent($data) {
        $this->db->query('INSERT INTO event (project_id, event_name, date, time, location, workers_required, payment_per_worker, end_date) 
                          VALUES (:project_id, :event_name, :date, :time, :location, :workers_required, :payment_per_worker, :end_date)');
        
        // Bind values
        $this->db->bind(':project_id', $data['project_id'], PDO::PARAM_STR);
        $this->db->bind(':event_name', $data['event_name'], PDO::PARAM_STR);
        $this->db->bind(':date', $data['date'], PDO::PARAM_STR);
        $this->db->bind(':time', $data['time'], PDO::PARAM_STR);
        $this->db->bind(':location', $data['location'], PDO::PARAM_STR);
        $this->db->bind(':workers_required', $data['workers_required'], PDO::PARAM_INT);
        $this->db->bind(':payment_per_worker', $data['payment_per_worker'], PDO::PARAM_STR);
        $this->db->bind(':end_date', $data['end_date'], PDO::PARAM_STR);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
