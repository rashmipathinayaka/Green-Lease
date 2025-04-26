<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/signup-styles.css">
</head>

<body>
    <div class="signup-section">
        <div class="signup-sidebar">
            <div class="sidebar-content">
                <div class="logo">🌿 Green Lease</div>
                <h1 class="sidebar-title">Welcome to Our Community</h1>
                <p class="sidebar-text">Join thousands of users who trust our platform for their land management needs.
                </p>
                <ul class="feature-list">
                    <li>Secure and verified transactions</li>
                    <li>Real-time updates and notifications</li>
                    <li>24/7 customer support</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="progress-bar"></div>

            <form id="signup-form" method="POST" action="<?= URLROOT ?>/Signup/register">
                <div class="signup-header">
                    <h2>Create an account</h2>
                    <p>Welcome on Board! Please enter your details</p>
                </div>
                <div class="role-select-container">
                    <div class="role-options">
                        <div class="role-option">
                            <input type="radio" id="buyer" name="role" value="buyer" required>
                            <label for="buyer">
                                <div class="icon">👥</div>
                                Buyer
                            </label>
                        </div>
                        <div class="role-option">
                            <input type="radio" id="landowner" name="role" value="landowner">
                            <label for="landowner">
                                <div class="icon">🏡</div>
                                Land Owner
                            </label>
                        </div>
                        <div class="role-option">
                            <input type="radio" id="worker" name="role" value="worker">
                            <label for="worker">
                                <div class="icon">⚒️</div>
                                Worker
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-container">
                    <div class="form-row">
                        <div class="form-column">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="nic">NIC Number</label>
                                <input type="text" id="nicNumber" name="nic" required pattern="^(?:\d{9}[VvXx]|\d{12})$"
                                    placeholder="Enter NIC number (old or new format)" oninput="validateNIC(this)">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" required>
                                <!-- <div class="password-strength"></div> -->
                            </div>
                        </div>
                        <div class="form-column">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label for="contact">Contact Number</label>
                                <input type="tel" id="contact" name="contact" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm-password">Confirm Password</label>
                                <input type="password" id="confirm-password" name="confirm-password" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="signup-button">Create Account</button>
                </div>
            </form>
            <div class="register-link">
                    Already have an account? <a href="<?= URLROOT ?>/login">Login</a>
            </div>
        </div>
    </div>
    <script src="<?= URLROOT ?>/assets/js/signup.js"></script>
</body>

</html>