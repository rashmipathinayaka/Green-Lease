<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/login-styles.css">
</head>

<body>
    <div class="login-section">
        <div class="login-sidebar">
            <div class="floating-shapes">
                <div class="shape"></div>
                <div class="shape"></div>
                <div class="shape"></div>
            </div>
            <div class="sidebar-content">
                <div class="logo">
                    🌿 Green Lease
                </div>
                <h1 class="sidebar-title">Welcome back</h1>
                <p class="sidebar-text">
                    Log in to access your personalized dashboard and continue managing your projects efficiently.
                </p>
                <ul class="feature-list">
                    <li>
                        <div class="feature-icon">
                            <i data-lucide="shield-check" color="white" size="16"></i>
                        </div>
                        Secure and verified transactions
                    </li>
                    <li>
                        <div class="feature-icon">
                            <i data-lucide="zap" color="white" size="16"></i>
                        </div>
                        Real-time updates and notifications
                    </li>
                    <li>
                        <div class="feature-icon">
                            <i data-lucide="smartphone" color="white" size="16"></i>
                        </div>
                        24/7 customer support
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content">
            <?php if (!empty(
                $error)) : ?>
                <div class="alert alert-danger" style="margin-top: -20px; margin-bottom: 13px; color: #b71c1c; background: #ffebee; border: 1px solid #ffcdd2; padding: 10px 16px; border-radius: 4px; text-align: center; font-size: 15px;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form class="form-container" method="POST" action="<?= URLROOT ?>/login">
                <div class="login-header">
                    <h2>Log in to your account</h2>
                    <p>Welcome back! Please enter your details</p>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <i class="input-icon" data-lucide="mail" size="20"></i>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <i class="input-icon" data-lucide="lock" size="20"></i>
                    <input type="password" name="password" id="password" required placeholder="Enter your password">
                </div>

                <div class="remember-forgot">
                    <label class="remember-me">
                        <input type="checkbox" id="remember">
                        Remember me
                    </label>
                    <div class="forgot-password">
                        <a href="<?= URLROOT ?>/forgotpassword">Forgot password?</a>
                    </div>
                </div>

                <button type="submit" class="login-button">Log In</button>

                <div class="register-link">
                    Don't have an account? <a href="<?= URLROOT ?>/signup">Sign up for free</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>