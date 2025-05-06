<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/login-styles.css">
</head>
<body>
    <div class="login-section">
        <div class="main-content">
            <form class="form-container" method="POST" action="">
                <div class="login-header">
                    <h2>Reset Password</h2>
                    <p>Enter your new password below.</p>
                </div>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" style="margin-bottom: 16px; color: #b71c1c; background: #ffebee; border: 1px solid #ffcdd2; padding: 10px 16px; border-radius: 4px; text-align: center; font-size: 15px;">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php elseif (!empty($message)): ?>
                    <div class="alert alert-success" style="margin-bottom: 16px; color: #256029; background: #e8f5e9; border: 1px solid #a5d6a7; padding: 10px 16px; border-radius: 4px; text-align: center; font-size: 15px;">
                        <?= $message ?>
                    </div>
                <?php endif; ?>
                <?php if (empty($error) && empty($message)): ?>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter new password">
                </div>
                <button type="submit" class="login-button">Reset Password</button>
                <?php endif; ?>
                <div class="register-link">
                    <a href="<?= URLROOT ?>/login">Back to login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 