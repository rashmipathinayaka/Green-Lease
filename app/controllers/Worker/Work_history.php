<?php

class Work_history extends Controller2
{

    public function index()
    {
        $worker_id = $_SESSION['id'] ?? null;

        if (!$worker_id) {
            redirect('login');
        }

        $filters = [
            'status' => $_GET['status'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? '',
            'event_name' => $_GET['event_name'] ?? '',
        ];

        $workerModel = new SWorker();
        $all_records = $workerModel->getAllWorkHistory($worker_id);

        $pending_work = [];
        $completed_work = [];

        foreach ($all_records as $work) {
            if ($filters['status'] && $work->status !== $filters['status']) continue;

            if ($filters['date_from'] && strtotime($work->date) < strtotime($filters['date_from'])) continue;
            if ($filters['date_to'] && strtotime($work->date) > strtotime($filters['date_to'])) continue;

            if ($filters['event_name'] && stripos($work->event_name, $filters['event_name']) === false) continue;

            if ($work->status === 'Pending') {
                $pending_work[] = $work;
            } elseif ($work->status === 'Completed') {
                $completed_work[] = $work;
            }
        }

        $this->view('worker/work_history', [
            'pending_work' => $pending_work,
            'completed_work' => $completed_work
        ]);
    }
}
