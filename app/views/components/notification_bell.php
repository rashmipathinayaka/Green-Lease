<li class="nav-item dropdown">
    <a class="nav-link" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-bell"></i>
        <span class="badge bg-danger notification-badge" id="notificationCount"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
        <div class="dropdown-header">
            Notifications
            <a href="<?php echo URLROOT; ?>/notifications" class="float-end text-decoration-none">View All</a>
        </div>
        <div id="notificationList" class="dropdown-list">
            <!-- Notifications will be loaded here -->
        </div>
    </div>
</li>

<script>
// Function to update notification count
function updateNotificationCount() {
    fetch('<?php echo URLROOT; ?>/notifications/get_unread_count')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notificationCount');
            if (data.count > 0) {
                badge.textContent = data.count;
                badge.style.display = 'inline';
            } else {
                badge.style.display = 'none';
            }
        });
}

// Update notification count every 30 seconds
updateNotificationCount();
setInterval(updateNotificationCount, 30000);
</script>

<style>
.notification-badge {
    position: absolute;
    top: 0;
    right: 0;
    font-size: 0.7rem;
    transform: translate(25%, -25%);
}

.dropdown-list {
    max-height: 300px;
    overflow-y: auto;
}
</style> 