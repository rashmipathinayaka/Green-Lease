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
        'image',
        'status',
        'description',
        'progress_notes',
        'completion_status',
        'completion_images'
    ];

    /**
     * Get today's events for specific projects
     * @param array $projectIds Array of project IDs
     * @return array Array of event objects
     */
    public function getTodaysEvents($projectIds)
    {
        if (empty($projectIds)) {
            return [];
        }

        // Prepare placeholders for the IN clause
        $placeholders = implode(',', array_fill(0, count($projectIds), '?'));

        // Get today's date
        $today = date('Y-m-d');

        $query = "SELECT e.*, p.crop_type 
                 FROM {$this->table} e
                 JOIN project p ON e.project_id = p.id
                 WHERE e.project_id IN ($placeholders)
                 AND DATE(e.date) = ?
                 ORDER BY e.date ASC";

        // Combine project IDs and today's date for binding
        $params = array_merge($projectIds, [$today]);

        return $this->query($query, $params);
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
}
