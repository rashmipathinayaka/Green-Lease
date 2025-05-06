<?php

class EventModel
{
    use Model;

    protected $table = 'event';

    protected $allowedColumns = [
        'id',
        'event_name',
        'project_id',
        'date',
        'status',
        'description',
        'progress_notes',
        'completion_status',
        'completion_images',
        'postponed',
        'postpone_details',
        'postponed_date'

    ];

    // Get today's events for a list of project IDs
    public function getTodaysEvents($projectId)
    {
        if (empty($projectId)) {
            return [];
        }

        // Get today's date
        $today = date('Y-m-d');

        $query = "SELECT e.*, p.crop_type,p.duration 
                 FROM {$this->table} e JOIN project p 
                 ON e.project_id = p.id
                 WHERE e.project_id = ? AND (( e.postponed = 'no' AND DATE(e.date) = ?) OR ( e.postponed = 'yes' AND DATE(e.postponed_date) = ?))
                 ORDER BY e.date ASC";

        return $this->query($query, [$projectId, $today, $today]);
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
                  AND (DATE(e.date) >= ? OR e.postponed_date >= ?)
                  ORDER BY COALESCE(e.postponed_date, e.date) ASC";

        return $this->query($query, [$projectId, $today, $today]);
    }

    public function getUpcomingEventsCount($projectId)
    {
        // Reuse getUpcomingEvents to fetch the data
        $upcomingEvents = $this->getUpcomingEvents($projectId);

        // Return the count of the results
        return count($upcomingEvents);
    }

    // Get events by status
    public function getEventsByStatus($projectId, $status)
    {
        $query = "SELECT * FROM event 
                  WHERE project_id = :project_id 
                  AND completion_status = :status
                  ORDER BY date ASC";

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
                      (DATE(e.date) < ? AND e.completion_status != 'completed' AND e.postponed_date IS NULL)
                  )
                  ORDER BY e.status DESC, e.date ASC";

        $params = array_merge($projectIds, [$today]);
        return $this->query($query, $params);
    }

    // Get events for a specific date range
    public function getEventsByDateRange($projectId, $startDate, $endDate)
    {
        $query = "SELECT * FROM {$this->table} 
                  WHERE project_id = :project_id 
                  AND (
                      (date BETWEEN :start_date AND :end_date) OR
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
                  ORDER BY date ASC";

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
}
