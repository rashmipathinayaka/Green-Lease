<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
        <div class="container">
            <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT; ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT; ?>/pages/about">About</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if(isset($_SESSION['id'])) : ?>
                        <?php require APPROOT . '/views/components/notification_bell.php'; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
    <!-- Add this in your navigation bar -->
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
    </div>
</body>
</html> 