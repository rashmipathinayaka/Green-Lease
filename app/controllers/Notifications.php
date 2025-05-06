<?php
class Notifications
{
    use Controller;

    public function markAllRead()
    {
        if (!isset($_SESSION['id'])) {
            http_response_code(403);
            exit;
        }
        $notificationModel = new Notification();
        $userId = $_SESSION['id'];
        // Mark all as read for this user
        $notificationModel->query("UPDATE notifications SET is_read = 1 WHERE user_id = :user_id", ['user_id' => $userId]);
        echo 'OK';
        exit;
    }
}
