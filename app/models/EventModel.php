<?php

class EventModel
{
    use Model;

    protected $table = 'event';

    protected $allowedColumns = [
        'id',
        'project_id',
        'event_name',
        'date',
        'time',
        'location',
        'workers_required',
        'payment_per_worker',
        'status',
        'description',
        'progress_notes',
        'completion_status',
        'completion_images'
    ];

    // Get all events for a specific project
    public function getEventsByProject($projectId)
    {
        $query = "SELECT * FROM event WHERE project_id = :project_id ORDER BY date ASC, time ASC";
        return $this->query($query, ['project_id' => $projectId]);
    }

    // Add a new event
    public function addEvent($data)
    {
        return $this->insert($data);
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
                  AND DATE(e.date) = ?
                  ORDER BY e.date ASC";

        $params = array_merge($projectIds, [$today]);
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
}
