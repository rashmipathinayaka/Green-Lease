<?php
class Index {

    use Controller;

    public function index()
    {
        $eventModel = new Event; // Assuming your model is named Event.php
        $events = $eventModel->getAvailableEvents();

        $this->view('worker/index', [
            'events' => $events
        ]);
    }
}
