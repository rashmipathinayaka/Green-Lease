<?php

class Work_history
{
    use Controller;

    public function index()
    {
        // You can retrieve worker_id from session if user is logged in
        $worker_id = $_SESSION['id'] ?? null;

        if (!$worker_id) {
            redirect('login');
        }

        $workerModel = new SWorker(); // using the new model
        $history = $workerModel->getWorkHistory($worker_id);

        $this->view('worker/work_history', ['history' => $history]);
    }
}
