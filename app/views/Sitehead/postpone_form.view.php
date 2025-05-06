<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postpone Event</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/sitehead/postponeForm.css">
</head>

<body>
    <?php
    require ROOT . '/views/sitehead/sidebar.php';
    require ROOT . '/views/components/topbar.php';
    ?>

    <div class="complaint-section">
        <div class="form-container">
            <h1>Postpone Event</h1>

            <div class="event-info">
                <div class="detail-row">
                    <span class="detail-label"><strong>Event Name: </strong></span>
                    <span class="detail-value"><?= htmlspecialchars($event->event_name) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><strong>Initial Planned Date:</strong></span>
                    <span class="detail-value"><?= date('F j, Y', strtotime($event->date)) ?></span>
                </div>
            </div>

            <form action="<?= URLROOT ?>/Sitehead/Event/postpone_event/<?= $event->id ?>" method="post">
                <div class="form-group">
                    <label for="postponed_date">New Proposed Date:</label>
                    <input type="date" id="postponed_date" name="postponed_date" required
                        min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                        class="date-input">
                </div>
                <div class="form-group">
                    <label for="postpone_reason">Reason for Postponing:</label>
                    <textarea id="postpone_reason" name="postpone_reason" required placeholder="Please provide the reason for postponing this event..."></textarea>
                </div>

                <div class="form-actions">
                    <a href="<?= URLROOT ?>/sitehead/Event/Upcoming_events" class="cancel-btn">Cancel</a>
                    <button type="submit" class="postpone-btn">Submit Postponement</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>