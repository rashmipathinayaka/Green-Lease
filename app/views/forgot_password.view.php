<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/login-styles.css">
</head>
<body>
    <div class="login-section">
        <div class="main-content">
            <form class="form-container" method="POST" action="">
                <div class="login-header">
                    <h2>Forgot Password</h2>
                    <p>Enter your email to receive a password reset link.</p>
                </div>
                <?php if (!empty($message)): ?>
                    <div class="alert alert-success" style="margin-bottom: 16px; color: #256029; background: #e8f5e9; border: 1px solid #a5d6a7; padding: 10px 16px; border-radius: 4px; text-align: center; font-size: 15px;">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>
                <button type="submit" class="login-button">Send Reset Link</button>
                <div class="register-link">
                    <a href="<?= URLROOT ?>/login">Back to login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 