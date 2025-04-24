<?php

class SWorker
{
    use Model;

    protected $table = 'worker_event';

    /**
     * Get work history of a specific worker
     */
    public function getWorkHistory($worker_id)
    {
        $query = "SELECT 
                    l.address AS land_location,
                    e.event_name,
                    e.date,
                    e.salary
                  FROM 
                    worker_event we
                  JOIN 
                    event e ON we.event_id = e.id
                  JOIN 
                    project p ON e.project_id = p.id
                  JOIN 
                    land l ON p.land_id = l.id
                  WHERE 
                    we.worker_id = :worker_id
                  ORDER BY 
                    e.date DESC";

        $params = [':worker_id' => $worker_id];

        try {
            return $this->query($query, $params) ?: [];
        } catch (Exception $e) {
            error_log("Failed to fetch work history: " . $e->getMessage());
            return [];
        }
    }
}
