<?php

class Message 
{
    use Model;
    
    protected $table = 'message_data';
    protected $allowedColumns = [
        'sender_id',
        'recipient_id',
        'message',
        'sent_at',
        'is_read',
        'is_deleted'
    ];
    
    // Get messages for a specific user
    public function getMessagesForUser($userId) 
    {
        $query = "SELECT m.*, 
                 s.username as sender_name, 
                 r.username as recipient_name 
                 FROM message_data m 
                 JOIN users s ON m.sender_id = s.id 
                 JOIN users r ON m.recipient_id = r.id 
                 WHERE (m.recipient_id = :user_id OR m.sender_id = :user_id) 
                 AND m.is_deleted = 0 
                 ORDER BY m.sent_at DESC";
        
        return $this->query($query, ['user_id' => $userId]);
    }
    
    // Get conversation between two users
    public function getConversation($userId, $otherUserId) 
    {
        $query = "SELECT m.*, 
                 s.username as sender_name, 
                 r.username as recipient_name 
                 FROM message_data m 
                 JOIN users s ON m.sender_id = s.id 
                 JOIN users r ON m.recipient_id = r.id 
                 WHERE (m.sender_id = :user_id AND m.recipient_id = :other_id) 
                 OR (m.sender_id = :other_id AND m.recipient_id = :user_id) 
                 AND m.is_deleted = 0 
                 ORDER BY m.sent_at ASC";
        
        return $this->query($query, [
            'user_id' => $userId,
            'other_id' => $otherUserId
        ]);
    }
    
    // Send a new message
    public function sendMessage($senderId, $recipientId, $messageText) 
    {
        $data = [
            'sender_id' => $senderId,
            'recipient_id' => $recipientId,
            'message' => $messageText,
            'sent_at' => date('Y-m-d H:i:s'),
            'is_read' => 0,
            'is_deleted' => 0
        ];
        
        return $this->insert($data);
    }
    
    // Mark message as read
    public function markAsRead($messageId, $userId) 
    {
        $query = "UPDATE message_data 
                 SET is_read = 1 
                 WHERE id = :message_id AND recipient_id = :user_id";
        
        return $this->query($query, [
            'message_id' => $messageId,
            'user_id' => $userId
        ]);
    }
    
    // Mark message as deleted
    public function deleteMessage($messageId, $userId) 
    {
        $query = "UPDATE message_data 
                 SET is_deleted = 1 
                 WHERE id = :message_id AND (sender_id = :user_id OR recipient_id = :user_id)";
        
        return $this->query($query, [
            'message_id' => $messageId,
            'user_id' => $userId
        ]);
    }
    
    // Get count of unread messages
    public function getUnreadCount($userId) 
    {
        $query = "SELECT COUNT(*) as count 
                 FROM message_data 
                 WHERE recipient_id = :user_id AND is_read = 0 AND is_deleted = 0";
        
        $result = $this->query($query, ['user_id' => $userId]);
        if ($result) {
            return $result[0]->count;
        }
        
        return 0;
    }
    
    // Get conversation list (users I've messaged with)
    public function getConversationList($userId) 
    {
        $query = "SELECT 
                 DISTINCT IF(m.sender_id = :user_id, m.recipient_id, m.sender_id) as other_user_id,
                 u.username as other_user_name,
                 (SELECT message FROM message_data 
                  WHERE (sender_id = :user_id1 AND recipient_id = IF(m.sender_id = :user_id2, m.recipient_id, m.sender_id)) 
                  OR (sender_id = IF(m.sender_id = :user_id3, m.recipient_id, m.sender_id) AND recipient_id = :user_id4)
                  ORDER BY sent_at DESC LIMIT 1) as last_message,
                 (SELECT sent_at FROM message_data 
                  WHERE (sender_id = :user_id5 AND recipient_id = IF(m.sender_id = :user_id6, m.recipient_id, m.sender_id)) 
                  OR (sender_id = IF(m.sender_id = :user_id7, m.recipient_id, m.sender_id) AND recipient_id = :user_id8)
                  ORDER BY sent_at DESC LIMIT 1) as last_message_time,
                 (SELECT COUNT(*) FROM message_data 
                  WHERE recipient_id = :user_id9 AND sender_id = IF(m.sender_id = :user_id10, m.recipient_id, m.sender_id) 
                  AND is_read = 0 AND is_deleted = 0) as unread_count
                 FROM message_data m
                 JOIN users u ON u.id = IF(m.sender_id = :user_id11, m.recipient_id, m.sender_id)
                 WHERE (m.sender_id = :user_id12 OR m.recipient_id = :user_id13)
                 AND m.is_deleted = 0
                 GROUP BY other_user_id, other_user_name
                 ORDER BY last_message_time DESC";
        
        return $this->query($query, [
            'user_id' => $userId,
            'user_id1' => $userId,
            'user_id2' => $userId,
            'user_id3' => $userId,
            'user_id4' => $userId,
            'user_id5' => $userId,
            'user_id6' => $userId,
            'user_id7' => $userId,
            'user_id8' => $userId,
            'user_id9' => $userId,
            'user_id10' => $userId,
            'user_id11' => $userId,
            'user_id12' => $userId,
            'user_id13' => $userId
        ]);
    }
}