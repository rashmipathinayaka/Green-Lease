<?php
class Event
{
    use Model;

    protected $table = 'event';

    public function getAvailableEvents()
    {
        return $this->query("SELECT * FROM event WHERE completion_status = 'pending'");
    }

    public function getAvailableEventsForWorker($worker_id)
    {
        return $this->query("
            SELECT e.*, l.address as land_address
            FROM event e 
            LEFT JOIN worker_event we ON e.id = we.event_id AND we.worker_id = ?
            JOIN project p ON e.project_id = p.id
            JOIN land l ON p.land_id = l.id
            WHERE e.completion_status = 'pending' 
            AND we.id IS NULL
        ", [$worker_id]);
    }

    public function first($where)
    {
        $keys = array_keys($where);
        $query = "SELECT * FROM event WHERE " . implode(' = ? AND ', $keys) . " = ? LIMIT 1";
        return $this->query($query, array_values($where))[0] ?? false;
    }
}
