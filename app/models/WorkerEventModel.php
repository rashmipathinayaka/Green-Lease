<?php
class WorkerEventModel
{
    use Model;

    protected $table = 'worker_event';
    protected $allowedColumns = [
        'id',
        'worker_id',
        'event_id',
        'status'
    ];

    /**
     * Get workers with their applied upcoming events for a specific project
     * 
     * @param int $projectId The project ID
     * @return array Array of worker data with their applied events
     */
    public function getWorkersWithUpcomingEvents($projectId)
    {
        $today = date('Y-m-d');

        $query = "SELECT 
                    u.id AS worker_id,
                    u.full_name AS worker_name,
                    u.email AS worker_email,
                    u.contact_no AS worker_phone,
                    e.id AS event_id,
                    e.event_name,
                    e.date AS event_date,
                    we.status AS application_status
                  FROM worker_event we
                  JOIN user u ON we.worker_id = u.id
                  JOIN event e ON we.event_id = e.id
                  WHERE e.project_id = ?
                  AND (DATE(e.date) >= ? OR e.postponed_date >= ?)
                  AND u.role_id = 6
                  ORDER BY  e.date";

        $params = [$projectId, $today, $today];

        $results = $this->query($query, $params);

        if (!$results) {
            return [];
        }

        // Organize the data by worker
        $workers = [];
        foreach ($results as $row) {
            $workerId = $row->worker_id;

            if (!isset($workers[$workerId])) {
                $workers[$workerId] = [
                    'id' => $workerId,
                    'name' => $row->worker_name,
                    'email' => $row->worker_email,
                    'phone' => $row->worker_phone,
                    'status' => 'Pending', // Default status
                    'applied_events' => []
                ];
            }

            $workers[$workerId]['applied_events'][] = [
                'event_id' => $row->event_id,
                'event_name' => $row->event_name,
                'date' => $row->event_date,
                'status' => $row->application_status
            ];
        }

        return array_values($workers);
    }

    public function updateStatus($workerId, $eventId, $status)
    {
        // First find the record with both worker_id and event_id
        $record = $this->first([
            'worker_id' => $workerId,
            'event_id' => $eventId
        ]);

        if ($record) {
            // Then use the existing update method with the record's ID
            return $this->update($record->id, ['status' => $status]);
        }

        return false;
    }

    public function first($where)
    {
        $keys = array_keys($where);
        $query = "SELECT * FROM worker_event WHERE " . implode(' = ? AND ', $keys) . " = ? LIMIT 1";
        return $this->query($query, array_values($where))[0] ?? false;
    }
}
