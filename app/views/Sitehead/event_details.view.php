<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/sitehead.css">
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/sitehead/eventDetails.css">
</head>

<body>
    <?php require ROOT . '/views/sitehead/sidebar.php'; ?>
    <?php require ROOT . '/views/components/topbar.php'; ?>

    <div class="admin-container">
        <div class="content">
            <div class="section">
                <div class="event-detail-container">
                    <div class="event-header">
                        <h1><?= htmlspecialchars($event->event_name) ?></h1>
                        <span class="status-badge <?= $event->completion_status ?>">
                            <?= ucfirst(str_replace('_', ' ', $event->completion_status)) ?>
                        </span>
                    </div>

                    <div class="event-meta">
                        <div>
                            <i class="fas fa-calendar-day"></i>
                            <span><?= date('F j, Y', strtotime($event->date)) ?></span>
                        </div>
                        <div>
                            <i class="fas fa-clock"></i>
                            <span><?= date('h:i A', strtotime($event->date)) ?></span>
                        </div>
                        <div>
                            <i class="fas fa-leaf"></i>
                            <span><?= htmlspecialchars($project->crop_type) ?></span>
                        </div>
                    </div>

                    <div class="event-description">
                        <p><?= htmlspecialchars($event->description) ?></p>
                    </div>

                    <?php if ($event->progress_notes) : ?>
                        <div class="progress-notes">
                            <h3>Progress Notes</h3>
                            <p><?= htmlspecialchars($event->progress_notes) ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($event->image_list)) : ?>
                        <div class="event-gallery">
                            <h3>Event Images</h3>
                            <div class="gallery-grid">
                                <?php foreach ($event->image_list as $image) :
                                    if (!empty($image)) : ?>
                                        <div class="gallery-item">
                                            <img src="http://localhost/Green-lease/app/uploads/event_images/<?= htmlspecialchars($image) ?>"
                                                alt="Event image">
                                            <a class="delete-image-btn"
                                                href="<?= URLROOT ?>/sitehead/Event/delete_image/<?= $event->id ?>/<?= urlencode($image) ?>"
                                                title="Delete Image"
                                                onclick="return confirm('Are you sure you want to delete this image?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="event-update-form">
                        <h3>Update Event Progress</h3>
                        <form method="POST" action="<?= URLROOT ?>/sitehead/Event/update/<?= $event->id ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="completion_status">Status</label>
                                <select name="completion_status" id="completion_status">
                                    <option value="pending" <?= $event->completion_status == 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="in_progress" <?= $event->completion_status == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                                    <option value="completed" <?= $event->completion_status == 'completed' ? 'selected' : '' ?>>Completed</option>
                                </select>

                                <label for="progress_notes">Progress Notes</label>
                                <textarea name="progress_notes" id="progress_notes" rows="5"><?= htmlspecialchars($event->progress_notes ?? '') ?></textarea>

                                <label for="completion_images">Upload Images</label>
                                <input type="file" name="completion_images[]" id="completion_images" multiple accept="image/*">
                                <small>You can select multiple images</small>

                                <button class="form-submit-btn" type="submit">Update Event</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>