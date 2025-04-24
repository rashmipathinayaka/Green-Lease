<?php

class Notifications
{
    use Controller;

    private $notificationModel;

    public function __construct()
    {
        if (!isset($_SESSION['id'])) {
            redirect('login');
        }
        $this->notificationModel = new Notification();
    }

    public function index()
    {
        $data['notifications'] = $this->notificationModel->get_all_notifications($_SESSION['id']);
        $this->view('notifications/index', $data);
    }

    public function mark_as_read($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($id) {
                $this->notificationModel->mark_as_read($id);
            } else {
                $this->notificationModel->mark_all_as_read($_SESSION['id']);
            }
        }
        redirect($_SERVER['HTTP_REFERER'] ?? 'notifications');
    }

    public function get_unread_count()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $count = $this->notificationModel->get_unread_count($_SESSION['id']);
            echo json_encode(['count' => $count]);
            exit;
        }
    }
} 