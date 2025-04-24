<?php

class Message
{
    use Controller;
    
    private $message;
    private $user;
    
    public function __construct()
    {
        // Check if user is logged in
        if(!Auth::logged_in())
        {
            redirect('login');
        }
        
        $this->message = new Message();
        $this->user = new User();
    }
    
    // Main inbox view
    public function index()
    {
        $userId = Auth::getUserId();
        $data['conversations'] = $this->message->getConversationList($userId);
        $data['unread_count'] = $this->message->getUnreadCount($userId);
        
        $this->view('messages/inbox', $data);
    }
    
    // View conversation with specific user
    public function conversation($otherUserId = null)
    {
        $userId = Auth::getUserId();
        
        // If otherUserId is not provided in URL, check GET
        if ($otherUserId === null && isset($_GET['user'])) {
            $otherUserId = (int)$_GET['user'];
        }
        
        if (!$otherUserId) {
            redirect('messages');
        }
        
        // Get other user details
        $data['other_user'] = $this->user->first(['id' => $otherUserId]);
        
        if (!$data['other_user']) {
            redirect('messages');
        }
        
        // Get conversation messages
        $data['messages'] = $this->message->getConversation($userId, $otherUserId);
        
        // Mark messages as read
        foreach ($data['messages'] as $message) {
            if ($message->recipient_id == $userId && $message->is_read == 0) {
                $this->message->markAsRead($message->id, $userId);
            }
        }
        
        $data['conversations'] = $this->message->getConversationList($userId);
        $data['unread_count'] = $this->message->getUnreadCount($userId);
        
        $this->view('messages/conversation', $data);
    }
    
    // Send a new message
    public function send()
    {
        $userId = Auth::getUserId();
        $response = ['success' => false];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $recipientId = $_POST['recipient_id'] ?? 0;
            $messageText = $_POST['message'] ?? '';
            
            if ($recipientId > 0 && !empty($messageText)) {
                $result = $this->message->sendMessage($userId, $recipientId, $messageText);
                
                if ($result) {
                    $response = [
                        'success' => true,
                        'message' => 'Message sent successfully'
                    ];
                    
                    // If AJAX request
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        echo json_encode($response);
                        exit;
                    }
                    
                    // Regular form submission
                    redirect('messages/conversation/' . $recipientId);
                }
            }
        }
        
        // If AJAX request and something went wrong
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode($response);
            exit;
        }
        
        // Regular form submission and something went wrong
        redirect('messages');
    }
    
    // Delete a message
    public function delete()
    {
        $userId = Auth::getUserId();
        $response = ['success' => false];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $messageId = $_POST['message_id'] ?? 0;
            
            if ($messageId > 0) {
                $result = $this->message->deleteMessage($messageId, $userId);
                
                if ($result) {
                    $response['success'] = true;
                }
            }
        }
        
        // If AJAX request
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode($response);
            exit;
        }
        
        // Regular form submission
        redirect('messages');
    }
}