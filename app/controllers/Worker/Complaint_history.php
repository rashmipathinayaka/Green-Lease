<?php

class Complaint_history extends Controller2
{

    public function index()
    {
        $worker_id = $_SESSION['id'] ?? null;

        if (!$worker_id) {
            redirect('login');
        }

        $workerModel = new SWorker();
        $recs = $workerModel->getWorkerComplaints();

        $data = [];

        $data[] = $recs;
        
        $this->view('worker/complaint_history', ['data' => $data]);
    }
}
