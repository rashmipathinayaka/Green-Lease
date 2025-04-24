<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/buyer.css">
    <title>Notifications</title>
</head>
<body style="margin-top: 100px; margin-left: 20px; margin-right: 20px;">
    <?php
    require ROOT . '/views/components/topbar.php';
    ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Notifications</h2>
                    <?php if (!empty($notifications)): ?>
                        <form action="<?php echo URLROOT; ?>/notifications/mark_as_read" method="POST" class="d-inline">
                            <button type="submit" class="btn btn-secondary">Mark All as Read</button>
                        </form>
                    <?php endif; ?>
                </div>

                <?php if (empty($notifications)): ?>
                    <div class="alert alert-info">No notifications found.</div>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($notifications as $notification): ?>
                            <div class="list-group-item list-group-item-action <?php echo $notification->is_read ? '' : 'active'; ?>">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><?php echo htmlspecialchars($notification->title); ?></h5>
                                    <small><?php echo date('M j, Y H:i', strtotime($notification->created_at)); ?></small>
                                </div>
                                <p class="mb-1"><?php echo htmlspecialchars($notification->message); ?></p>
                                <?php if (!$notification->is_read): ?>
                                    <form action="<?php echo URLROOT; ?>/notifications/mark_as_read/<?php echo $notification->id; ?>" method="POST" class="mt-2">
                                        <button type="submit" class="btn btn-sm btn-light">Mark as Read</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html> 