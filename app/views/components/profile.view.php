<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/profile.css">
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <div class="profile-card">
        <img src="<?= URLROOT ?>/assets/Images/supervisor.jpg" alt="Profile Picture" class="profile-picture">
        <h2><?php echo htmlspecialchars($user->full_name); ?></h2>
            <p>Email: <?php echo htmlspecialchars($user->email); ?></p>
            <p>contact no: <?php echo htmlspecialchars($user->contact_no); ?></p>

            <p>Joined: <?php echo htmlspecialchars($user->joined_date); ?></p>
        </div>
        <!-- <button class="btn" onclick="window.location.href='<?= URLROOT ?>/Admin/manage_supervisor/'">Go Back</a> -->
    </div>
</body>
</html>