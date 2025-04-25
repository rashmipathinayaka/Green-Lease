<?php
class WorkerEventModel
{
    use Model;

    protected $table = 'worker_event';
    protected $allowedColumns = [
        'id',
        'worker_id',
        'event_id'
    ];

    public function getWorkerEvents($workerId)
    {
        return $this->where(['worker_id' => $workerId]);
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
}
