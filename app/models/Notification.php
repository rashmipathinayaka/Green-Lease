<?php

class Notification
{
    use Model;

    protected $table = 'notifications';
    protected $allowedColumns = [
        'user_id',
        'title',
        'message',
        'type',
        'is_read',
        'created_at'
    ];

    // Create a new notification
    public function create_notification($user_id, $title, $message, $type = 'info')
    {
        return $this->insert([
            'user_id' => $user_id,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'is_read' => false
        ]);
    }

    // Get all unread notifications for a user
    public function get_unread_notifications($user_id)
    {
        return $this->where([
            'user_id' => $user_id,
            'is_read' => false
        ]);
    }

    // Get all notifications for a user
    public function get_all_notifications($user_id)
    {
        return $this->query(
            "SELECT * FROM $this->table WHERE user_id = :user_id ORDER BY created_at DESC",
            ['user_id' => $user_id]
        );
    }

    // Mark a notification as read
    public function mark_as_read($notification_id)
    {
        return $this->update($notification_id, [
            'is_read' => true
        ]);
    }

    // Mark all notifications as read for a user
    public function mark_all_as_read($user_id)
    {
        return $this->query(
            "UPDATE $this->table SET is_read = true WHERE user_id = :user_id",
            ['user_id' => $user_id]
        );
    }

    // Get unread notification count for a user
    public function get_unread_count($user_id)
    {
        $result = $this->query(
            "SELECT COUNT(*) as count FROM $this->table WHERE user_id = :user_id AND is_read = false",
            ['user_id' => $user_id]
        );
        return $result[0]->count ?? 0;
    }
} 