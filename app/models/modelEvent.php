<?php

class modelEvent
{
    use Model;

    protected $table = 'event';

    protected $allowedColumns = [
        'id',
        'project_id',
        'event_name',
        'date',
        'time',
        'workers_required',
        'payment_per_worker',
        'status',
        'description',
        'postponed',
        'postponed_date',
        'progress_notes',
        'completion_status',
        'completion_images'
    ];

    // Get all events for a specific project
    // In app/models/modelEvent.php

// Modify the getEventsByProject method
public function getEventsByProject($projectId)
{
    $query = "SELECT * FROM event WHERE project_id = :project_id ORDER BY COALESCE(postponed_date, date) DESC, time ASC";
    $events = $this->query($query, ['project_id' => $projectId]);
    
    // Process each event to add display properties
    foreach ($events as $event) {
        $event->is_postponed = !empty($event->postponed_date);
        $event->display_date = $event->is_postponed ? $event->postponed_date : $event->date;
    }
    
    return $events;
}


    // Add a new event (simplified with default values)
    public function addEvent($data)
    {
        $query = "INSERT INTO event (project_id, event_name, date, time, workers_required, payment_per_worker, status, description, progress_notes, completion_status, completion_images, postponed_date)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        $params = [
            $data['project_id'] ?? null,
            $data['event_name'] ?? null,
            $data['date'] ?? null,
            $data['time'] ?? null,
            $data['workers_required'] ?? 0,
            $data['payment_per_worker'] ?? 0,
            $data['status'] ?? 0,
            $data['description'] ?? '',
            $data['progress_notes'] ?? '',
            $data['completion_status'] ?? 'Pending',
            $data['completion_images'] ?? null,
            $data['postponed_date'] ?? null
        ];
    
        // Run the query
        $result = $this->query($query, $params);
    
        // ✅ Always check if $result is not false
        return $result !== false;
    }
    
    // Get today's events for a list of project IDs
    public function getTodaysEvents($projectIds)
    {
        if (empty($projectIds)) return [];

        $placeholders = implode(',', array_fill(0, count($projectIds), '?'));
        $today = date('Y-m-d');

        $query = "SELECT e.*, p.crop_type 
                  FROM event e
                  JOIN project p ON e.project_id = p.id
                  WHERE e.project_id IN ($placeholders)
                  AND (
                      (DATE(e.date) = ? AND e.postponed_date IS NULL) OR
                      (DATE(e.postponed_date) = ?)
                  )
                  ORDER BY e.time ASC";

        $params = array_merge($projectIds, [$today, $today]);
        return $this->query($query, $params);
    }

    // Get a single event along with image list
    public function getEventWithImages($eventId)
    {
        $event = $this->first(['id' => $eventId]);
        if ($event && $event->completion_images) {
            $event->image_list = json_decode($event->completion_images, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $event->image_list = [];
            }
        } else if ($event) {
            $event->image_list = [];
        }
        return $event;
    }

    // Update an existing event
    public function updateEvent($id, $data)
    {
        return $this->update($id, $data);
    }

    // Delete an event
    public function deleteEvent($id)
    {
        return $this->delete($id);
    }

    // Get upcoming events for a project
    public function getUpcomingEvents($projectId)
    {
        if (empty($projectId)) {
            return [];
        }

        $today = date('Y-m-d');

        $query = "SELECT e.*, p.crop_type 
                  FROM {$this->table} e
                  JOIN project p ON e.project_id = p.id
                  WHERE e.project_id = ?
                  AND (
                      (DATE(e.date) >= ? AND e.postponed_date IS NULL) OR 
                      (DATE(e.postponed_date) >= ?)
                  )
                  ORDER BY COALESCE(e.postponed_date, e.date) ASC";

        return $this->query($query, [$projectId, $today, $today]);
    }
    
    // Get events by status
    public function getEventsByStatus($projectId, $status)
    {
        $query = "SELECT * FROM event 
                  WHERE project_id = :project_id 
                  AND completion_status = :status
                  ORDER BY COALESCE(postponed_date, date) ASC";
                  
        return $this->query($query, [
            'project_id' => $projectId,
            'status' => $status
        ]);
    }
    
    // Count events by status
    public function countEventsByStatus($projectId, $status)
    {
        $query = "SELECT COUNT(*) as count FROM event 
                  WHERE project_id = :project_id 
                  AND completion_status = :status";
                  
        $result = $this->query($query, [
            'project_id' => $projectId,
            'status' => $status
        ]);
        
        return $result[0]->count ?? 0;
    }
    
    // Get events that need attention (high priority or overdue)
    public function getEventsNeedingAttention($projectIds)
    {
        if (empty($projectIds)) return [];
        
        $placeholders = implode(',', array_fill(0, count($projectIds), '?'));
        $today = date('Y-m-d');
        
        $query = "SELECT e.*, p.crop_type 
                  FROM event e
                  JOIN project p ON e.project_id = p.id
                  WHERE e.project_id IN ($placeholders)
                  AND (
                      (e.status = 1 AND e.completion_status != 'completed') OR
                      (DATE(COALESCE(e.postponed_date, e.date)) < ? AND e.completion_status != 'completed')
                  )
                  ORDER BY e.status DESC, COALESCE(e.postponed_date, e.date) ASC";
                  
        $params = array_merge($projectIds, [$today]);
        return $this->query($query, $params);
    }
    
    // Get events for a specific date range
    public function getEventsByDateRange($projectId, $startDate, $endDate)
    {
        $query = "SELECT * FROM {$this->table} 
                  WHERE project_id = :project_id 
                  AND (
                      (date BETWEEN :start_date AND :end_date AND postponed_date IS NULL) OR
                      (postponed_date BETWEEN :start_date AND :end_date)
                  )
                  ORDER BY COALESCE(postponed_date, date) ASC";
                  
        return $this->query($query, [
            'project_id' => $projectId,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }
    
    // Check if an event exists
    public function eventExists($eventId)
    {
        $query = "SELECT COUNT(*) as count FROM event WHERE id = :id";
        $result = $this->query($query, ['id' => $eventId]);
        return ($result[0]->count > 0);
    }
    
    // Get events with worker requirements
    public function getEventsWithWorkerRequirements($projectId)
    {
        $query = "SELECT * FROM event 
                  WHERE project_id = :project_id 
                  AND workers_required > 0
                  AND completion_status != 'Completed'
                  ORDER BY COALESCE(postponed_date, date) ASC";
                  
        return $this->query($query, ['project_id' => $projectId]);
    }
    
    // Calculate total worker payment for a project
    public function calculateTotalWorkerPayment($projectId)
    {
        $query = "SELECT SUM(workers_required * payment_per_worker) as total 
                  FROM event 
                  WHERE project_id = :project_id";
                  
        $result = $this->query($query, ['project_id' => $projectId]);
        return $result[0]->total ?? 0;
    }
    
    // Helper method to get the correct display date for an event
    public function getDisplayDate($event)
    {
        return !empty($event->postponed_date) ? $event->postponed_date : $event->date;
    }
    
    // Helper method to check if an event is postponed
    public function isPostponed($event)
    {
        return !empty($event->postponed_date);
    }
    
    // Get formatted display date with postponed indicator
    public function getFormattedDisplayDate($event)
    {
        $date = $this->getDisplayDate($event);
        $formatted = date('M j, Y', strtotime($date));
        
        if ($this->isPostponed($event)) {
            return $formatted . ' (Postponed)';
        }
        
        return $formatted;
    }
}
