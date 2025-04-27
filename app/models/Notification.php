<?php
class Notification
{
    use Model;

    protected $table = 'notifications';

    protected $allowedColumns = [
        'user_id',
        'type',
        'message',
        'link',
        'is_read',
        'created_at'
    ];

    // Insert a new notification
    public function create($data)
    {
        // Add created_at timestamp if not provided
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        // Set is_read to 0 by default if not provided
        if (!isset($data['is_read'])) {
            $data['is_read'] = 0;
        }
        return $this->insert($data);
    }

    // Get notifications for a user
    public function getForUser($userId, $onlyUnread = false)
    {
        $query = "SELECT * FROM notifications WHERE user_id = :user_id";
        if ($onlyUnread) {
            $query .= " AND is_read = 0";
        }
        $query .= " ORDER BY created_at DESC";
        $result = $this->query($query, ['user_id' => $userId]);
        return $result ?: [];
    }

    // Mark notification as read
    public function markAsRead($id)
    {
        return $this->update($id, ['is_read' => 1]);
    }
}
