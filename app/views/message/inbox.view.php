<?php $this->view('includes/header'); ?>

<div class="message-container">
    <div class="message-sidebar">
        <div class="message-header">
            <h2>Messages</h2>
            <span class="message-count"><?= $unread_count ?> Unread</span>
        </div>
        
        <div class="message-conversations">
            <?php if (empty($conversations)): ?>
                <div class="no-messages">
                    <p>No conversations yet</p>
                </div>
            <?php else: ?>
                <?php foreach ($conversations as $conversation): ?>
                    <a href="<?=ROOT?>/messages/conversation/<?= $conversation->other_user_id ?>" 
                       class="conversation-item <?= $conversation->unread_count > 0 ? 'unread' : '' ?>">
                        <div class="conversation-user"><?= htmlspecialchars($conversation->other_user_name) ?></div>
                        <div class="conversation-preview">
                            <?= htmlspecialchars(substr($conversation->last_message, 0, 50)) ?>
                            <?= strlen($conversation->last_message) > 50 ? '...' : '' ?>
                        </div>
                        <div class="conversation-time">
                            <?= date('M j', strtotime($conversation->last_message_time)) ?>
                            <?php if ($conversation->unread_count > 0): ?>
                                <span class="unread-badge"><?= $conversation->unread_count ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="message-content empty">
        <div class="message-placeholder">
            <div class="placeholder-icon">💬</div>
            <h3>Select a conversation</h3>
            <p>Choose a conversation from the list or start a new one</p>
        </div>
    </div>
</div>

<?php $this->view('includes/footer'); ?>