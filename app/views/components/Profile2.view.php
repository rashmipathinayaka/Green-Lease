<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/components/profile2.css">

    <title>User Profile</title>

</head>

<body>
    <div class="profile-container">
        <div class="top-green-bar"></div>
        <div class="profile-content">
            <div class="profile-sidebar">
                <div class="profile-photo">
                    <?php if ($user->propic): ?>
                        <img src="<?= URLROOT ?>/assets/Images/<?= htmlspecialchars($user->propic) ?>" alt="Profile Picture" class="profile-photo">
                    <?php else: ?>
                        <img src="<?= URLROOT ?>/assets/images/user.png" alt="Default Profile Picture" class="profile-photo">
                    <?php endif; ?>

                    <!-- Toggle button -->
                    <button onclick="toggleForm()" class="update-btn">Update Profile Picture</button>

                    <!-- Hidden form -->
                     <div class="updateForm">
                    <form id="updateForm" class="updateForm" action="<?= URLROOT ?>/profile2/updatepropic" method="POST" enctype="multipart/form-data" style="display: none;">
                        <!-- <h4>Select new profile photo</h4> -->
                        <input type="file" name="profile_pic" accept="image/*" required>
                        <button type="submit" class="update-btn" name="submit_pic">Submit</button>
                    </form></div>
                </div>

                <!-- JavaScript to toggle form visibility -->


                <br><br><br> <br><br><br>

                <div class="profile-name">
                    <h2><?php echo htmlspecialchars($user->full_name); ?></h2>
                </div>
                <div class="profile-role">
                    <p>Role: <?php
                                if ($user->role_id == 1) {
                                    echo "Admin";
                                } elseif ($user->role_id == 2) {
                                    echo "Supervisor";
                                } elseif ($user->role_id == 3) {
                                    echo "Sitehead";
                                } elseif ($user->role_id == 4) {
                                    echo "Landowner";
                                } elseif ($user->role_id == 5) {
                                    echo "Buyer";
                                } else {
                                    echo "worker";
                                };

                                ?></p>
                </div>

                <div class="profile-nic">
                    <p>NIC : <?php echo htmlspecialchars($user->nic); ?></p>
                </div>




                <br>
                <div class="contact-list">
                    <div class="contact-item">
                        <svg class="contact-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"></path>
                        </svg>
                        <span class="contact-text"><?php echo htmlspecialchars($user->contact_no); ?></span>
                    </div>
                    <div class="contact-item">
                        <svg class="contact-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path>
                        </svg>
                        <span class="contact-text"><?php echo htmlspecialchars($user->email); ?></span>
                    </div>
                    <div class="contact-item">
                        <svg class="contact-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path>
                        </svg>
                        <span class="contact-text"><?php echo htmlspecialchars($user->joined_date); ?></span>
                    </div>
                </div>
            </div>



            <form action="<?= URLROOT ?>/Profile2/updateprofile" method="POST" id="profileForm">
                <div class="profile-details">
                    <div class="details-header">
                        <h2 class="details-title">Profile Information</h2>
                        <p class="details-subtitle">Personal and employment details</p>
                    </div>
                    <input type="number" name="id" hidden value="<?php echo htmlspecialchars($user->id); ?>" class="info-value info-input">

                    <div class="details-grid">
                        <div class="info-card">
                            <div class="info-label">Full Name</div>
                            <input type="text" name="full_name" value="<?php echo htmlspecialchars($user->full_name); ?>" class="info-value info-input" disabled>
                            <?php if (isset($errors['full_name'])): ?>
                                <div class="error-message"><?php echo htmlspecialchars($errors['full_name']); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="info-card">
                            <div class="info-label">Email</div>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($user->email); ?>" class="info-value info-input" disabled>
                            <?php if (isset($errors['email'])): ?>
                                <div class="error-message"><?php echo htmlspecialchars($errors['email']); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="info-card">
                            <div class="info-label">National ID</div>
                            <input type="number" name="nic" value="<?php echo htmlspecialchars($user->nic); ?>" class="info-value info-input" disabled>
                            <?php if (isset($errors['nic'])): ?>
                                <div class="error-message"><?php echo htmlspecialchars($errors['nic']); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="info-card">
                            <div class="info-label">Contact no</div>
                            <input type="number" name="contact_no" value="<?php echo htmlspecialchars($user->contact_no); ?>" class="info-value info-input" disabled>
                            <?php if (isset($errors['contact_no'])): ?>
                                <div class="error-message"><?php echo htmlspecialchars($errors['contact_no']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if (isset($error)): ?>
                    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <div class="footer">
                    <div class="footer-text"></div>
                    <button type="button" class="update-btn" id="editButton">Update Profile</button>
                    <button type="submit" class="save-btn" name="action" value="save" id="saveButton" style="display: none;">Save Changes</button>
                </div>
            </form>

        </div>
</body>

<script>
    document.getElementById('editButton').addEventListener('click', function() {
        const inputs = document.querySelectorAll('.info-input');
        inputs.forEach(input => {
            input.removeAttribute('disabled');
        });

        // Show Save button, hide Edit button
        document.getElementById('saveButton').style.display = 'inline-block';
        document.getElementById('editButton').style.display = 'none';
    });

    function toggleForm() {
        const form = document.getElementById('updateForm');
        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'flex'; // using flex to match CSS
        } else {
            form.style.display = 'none';
        }
    }


</script>


</html>