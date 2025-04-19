<?php $this->view('includes/header'); ?>

<div class="message-container">
    <div class="message-sidebar">
        <div class="message-header">
            <h2>Messages</h2>
            <a href="<?=ROOT?>/messages" class="back-to-inbox">Back to Inbox</a>
        </div>
        
        <div class="message-conversations">
            <?php foreach ($conversations as $convo): ?>
                <a href="<?=ROOT?>/messages/conversation/<?= $convo->other_user_id ?>" 
                   class="conversation-item <?= $convo->other_user_id == $other_user->id ? 'active' : '' ?> <?= $convo->unread_count > 0 ? 'unread' : '' ?>">
                    <div class="conversation-user"><?= htmlspecialchars($convo->other_user_name) ?></div>
                    <div class="conversation-preview">
                        <?= htmlspecialchars(substr($convo->last_message, 0, 50)) ?>
                        <?= strlen($convo->last_message) > 50 ? '...' : '' ?>
                    </div>
                    <div class="conversation-time">
                        <?= date('M j', strtotime($convo->last_message_time)) ?>
                        <?php if ($convo->unread_count > 0): ?>
                            <span class="unread-badge"><?= $convo->unread_count ?></span>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="message-content">
        <div class="conversation-header">
            <h3><?= htmlspecialchars($other_user->username) ?></h3>
        </div>
        
        <div class="conversation-messages" id="message-list">
            <?php if (empty($messages)): ?>
                <div class="no-messages">
                    <p>No messages yet. Start the conversation!</p>
                </div>
            <?php else: ?>
                <?php foreach ($messages as $message): ?>
                    <div class="message <?= $message->sender_id == Auth::getUserId() ? 'outgoing' : 'incoming' ?>">
                        <div class="message-bubble">
                            <div class="message-text"><?= htmlspecialchars($message->message) ?></div>
                            <div class="message-time"><?= date('M j, g:i a', strtotime($message->sent_at)) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="message-compose">
            <form id="message-form" action="<?=ROOT?>/messages/send" method="post">
                <input type="hidden" name="recipient_id" value="<?= $other_user->id ?>">
                <textarea name="message" placeholder="Type your message..." required></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
</div>

<script>
// Scroll to bottom of messages on page load
document.addEventListener('DOMContentLoaded', function() {
    const messageList = document.getElementById('message-list');
    messageList.scrollTop = messageList.scrollHeight;
    
    // Optional: Submit form with AJAX to avoid page reload
    const messageForm = document.getElementById('message-form');
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('<?=ROOT?>/messages/send', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add the sent message to the conversation
                const messageList = document.getElementById('message-list');
                
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message outgoing';
                
                const messageBubble = document.createElement('div');
                messageBubble.className = 'message-bubble';
                
                const messageText = document.createElement('div');
                messageText.className = 'message-text';
                messageText.textContent = formData.get('message');
                
                const messageTime = document.createElement('div');
                messageTime.className = 'message-time';
                messageTime.textContent = new Date().toLocaleString('en-US', { 
                    month: 'short', 
                    day: 'numeric', 
                    hour: 'numeric', 
                    minute: 'numeric', 
                    hour12: true 
                });
                
                messageBubble.appendChild(messageText);
                messageBubble.appendChild(messageTime);
                messageDiv.appendChild(messageBubble);
                messageList.appendChild(messageDiv);
                
                // Clear the textarea
                messageForm.querySelector('textarea').value = '';
                
                // Scroll to the bottom
                messageList.scrollTop = messageList.scrollHeight;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
</script>

<?php $this->view('includes/footer'); ?>