<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Issue Submitted</title>
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/sitehead/issue_success.css">
</head>

<body>
    <?php
    require ROOT . '/views/sitehead/sidebar.php';
    require ROOT . '/views/components/topbar.php';
    ?>

    <div class="confirmation-message-container">
        <h1 class="success-title">Issue Submitted Successfully</h1>
        <p class="success-description">Thank you for reporting the issue. Our team will review it and get back to you as soon as possible.</p>
        <div class="button-group">
            <button class="home-btn" onclick="window.location.href='<?= URLROOT ?>/Sitehead/Index'">Home</button>
            <button class="history-btn" onclick="window.location.href='<?= URLROOT ?>/Sitehead/Feedback'">View Sent<br>Issues History</button>
        </div>
    </div>
</body>

</html>