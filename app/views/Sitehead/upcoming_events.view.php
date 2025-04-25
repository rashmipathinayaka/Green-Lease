<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/sitehead.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/sitehead/upcoming_events.css">
</head>

<body>
    <?php
    require ROOT . '/views/sitehead/sidebar.php';
    require ROOT . '/views/components/topbar.php';
    ?>
    <div class="upcoming-events-container">
        <div class="upcoming-events-header">
            <h1>Upcoming Events</h1>
            <p>All scheduled events from today onwards</p>
        </div>

        <div class="events-list">
            <?php if (!empty($upcomingEvents)) : ?>
                <?php
                $today = date('Y-m-d');
                foreach ($upcomingEvents as $event) :
                    $isToday = date('Y-m-d', strtotime($event->date)) === $today;
                    $isPostponed = !empty($event->postponed_date);
                    $displayDate = $isPostponed ? $event->postponed_date : $event->date;
                    $isDisplayToday = date('Y-m-d', strtotime($displayDate)) === $today;
                ?>
                    <div class="event-card <?= $event->status == 1 ? 'high-priority' : 'medium-priority' ?> <?= $isPostponed ? 'postponed-event' : '' ?>">
                        <div class="event-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="event-details">
                            <div class="event-header">
                                <h3><?= htmlspecialchars($event->event_name) ?></h3>
                                <div class="status-badges">
                                    <?php if ($isPostponed) : ?>
                                        <span class="postponed-badge">Postponed</span>
                                    <?php endif; ?>
                                    <span class="priority-badge">
                                        <?= $event->status == 1 ? 'High Priority' : 'Medium Priority' ?>
                                    </span>
                                </div>
                            </div>
                            <div class="event-info vertical">
                                <?php if ($isDisplayToday) : ?>
                                    <span><i class="fas fa-calendar-day"></i> Today</span>
                                <?php else : ?>
                                    <span><i class="fas fa-calendar"></i> <?= date('M j, Y', strtotime($displayDate)) ?></span>
                                <?php endif; ?>
                                <span><i class="fas fa-leaf"></i> <?= htmlspecialchars($event->crop_type) ?></span>
                                <span><i class="fas fa-align-left"></i> <?= htmlspecialchars(substr($event->description, 0, 500)) ?>...</span>
                            </div>
                            <div class="event-actions">

                                <a href="<?= URLROOT ?>/sitehead/Event/postpone_event/<?= $event->id ?>" class="btn postpone-btn" onclick="return confirm('Are you sure you want to postpone this event?')">Postpone</a>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="upcoming-no-events">
                    <i class="fas fa-calendar-times"></i>
                    <p>No upcoming events scheduled</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>