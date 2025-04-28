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

    /**
     * Get today's events for specific projects
     * @param array $projectIds Array of project IDs
     * @return array Array of event objects
     */
    public function getTodaysEvents($projectId)
    {
        if (empty($projectId)) {
            return [];
        }

        // Get today's date
        $today = date('Y-m-d');

        $query = "SELECT e.*, p.crop_type 
                 FROM {$this->table} e
                 JOIN project p ON e.project_id = p.id
                 WHERE e.project_id = ?
                 AND (DATE(e.date) = ? OR e.postponed_date = ?)
                 ORDER BY e.date ASC";

        return $this->query($query, [$projectId, $today, $today]);
    }

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
}
