<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Fertilizer Request Submitted</title>
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/sitehead/issue_success.css">
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/sitehead.css">
</head>

<body>
    <?php
    require ROOT . '/views/sitehead/sidebar.php';
    require ROOT . '/views/components/topbar.php';
    ?>
    <div class="confirmation-message-container">
        <h1 class="success-title">Fertilizer Request Submitted Successfully</h1>
        <p class="success-description">Your fertilizer request has been submitted. You'll be contacted shortly regarding further processing.</p>
        <button class="home-btn" onclick="window.location.href='<?= URLROOT ?>/Sitehead/Index'">Home</button>
    </div>
</body>

</html>