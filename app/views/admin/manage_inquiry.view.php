<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inquiries</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/admin/inq.css">
</head>
<body>


<?php

require ROOT . '/views/admin/sidebar.php';
require ROOT . '/views/components/topbar.php';

?>


    <div class="container">
        <h1><i class="fas fa-envelope-open-text"></i> Customer Inquiries</h1>
        
        <div class="inquiry-list">
            <?php if (!empty($inquiries)): ?>
                <?php foreach ($inquiries as $inquiry): ?>
                    <div class="inquiry-item">
                        <div class="inquiry-header">
                            <span class="inquiry-email"><?= htmlspecialchars($inquiry->email) ?></span>
                            <span class="inquiry-status <?= $inquiry->is_solved == '1' ? 'status-solved' : 'status-pending' ?>">
                                <?= $inquiry->is_solved == '1' ? 'Solved' : 'Pending' ?>
                            </span>
                        </div>
                        <div class="inquiry-subject"><?= htmlspecialchars($inquiry->subject) ?></div>
                        <p class="inquiry-message">
                            <?= htmlspecialchars($inquiry->message) ?>
                        </p>
                        <div class="inquiry-footer">
                            <div class="inquiry-actions">
                                <?php if ($inquiry->is_solved == '0'): ?>
                                    <button class="btn btn-view" onclick="window.location.href='<?= URLROOT ?>/admin/manage_inquiry/solved/<?= $inquiry->id ?>'">
                                        <i class="fas fa-eye"></i> Mark as Solved
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-solve" onclick="window.location.href='<?= URLROOT ?>/admin/manage_inquiry/delete/<?= $inquiry->id ?>'">
                                        <i class="fas fa-check"></i> Delete
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-inquiries">
                    <i class="fas fa-inbox"></i>
                    <p>No inquiries found</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
