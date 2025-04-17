<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Worker Dashboard</title>
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/worker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<?php
require ROOT . '/views/worker/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>

    <div class="worker-events-section">
        <div class="worker-events-header" style="margin-top: 120px;">
            <h2>Available Events</h2>
            <div class="worker-event-filter">
                <input type="text" placeholder="Search by project ID or date">
                <button><i class="fas fa-search"></i></button>
            </div>
        </div>

        <div class="worker-events-list">
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): ?>
                    <div class="worker-event-card">
                        <div class="worker-event-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="worker-event-details">
                            <div class="worker-event-header">
                                <h3><?= htmlspecialchars($event->event_name) ?></h3>
                            </div>
                            <div class="worker-event-info">
                                <span><i class="fas fa-clock"></i> <?= $event->date?></span>
                                <span><i class="fas fa-map-pin"></i> Project ID: <?= $event->project_id ?></span>
                                <span><i class="fas fa-user"></i> Assigned Supervisor</span> <!-- You can customize this if you join with supervisor table -->
                            </div>
                        </div>
                        <div class="worker-event-actions">
                            <button class="green-btn">Apply</button>
                            <button class="red-btn">Remove</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-events-message">No available events right now.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
