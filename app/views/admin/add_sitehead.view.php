<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/landowner/registerlands.css">
    <title>Add Sitehead</title>
</head>

<body>

    <?php

    require ROOT . '/views/components/topbar.php';

    ?>



    <div id="register-lands-section" class="section">
        <div class="form-container">
            <h1 class="register-topic">Fill in Sitehead Details</h1>
            <br>
            <form class="form" action="<?= URLROOT ?>/Admin/add_sitehead" method="POST"
                enctype="multipart/form-data">
                <div class="form-group">

                  <label for="full_name">Full Name:</label>
<input type="text" id="full_name" name="full_name" required>
<span id="full_name_error" class="error"></span>

<label for="email">Email:</label>
<input type="email" id="email" name="email" required>
<span id="email_error" class="error"></span>

<label for="contact_no">Phone Number:</label>
<input type="number" id="contact_no" name="contact_no" required>
<span id="contact_error" class="error"></span>

<label for="nic">NIC:</label>
<input type="number" id="nic" name="nic" required>
<span id="nic_error" class="error"></span>



                    <label for="zone">Zone:</label>
                    <select id="zone" name="zone" required>
                        <option value="">Select Zone</option>
                        <?php foreach ($zones as $zone): ?>
                            <option value="<?= htmlspecialchars($zone->id) ?>"
                                <?= isset($_GET['zone']) && $_GET['zone'] == $zone->id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($zone->zone_name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <input type="text" id="status" name="status" hidden>

                    <button class="form-submit-btn" type="submit">
                        <i class="fas fa-paper-plane"></i>&nbsp;Submit</button>
                    <button class="black-btn" onclick="window.location.href='<?= URLROOT ?>/Admin/manage_sitehead/'">Go back</button>


                </div>
            </form>
        </div>
    </div>
</body>
    <script>
    document.querySelector('.form').addEventListener('submit', function(e) {
        let isValid = true;

        // Clear previous error messages
        document.querySelectorAll('.error').forEach(el => el.textContent = '');

        const fullName = document.getElementById('full_name').value.trim();
        const email = document.getElementById('email').value.trim();
        const contact = document.getElementById('contact_no').value.trim();
        const nic = document.getElementById('nic').value.trim();

        // Full name check: only letters and spaces
        if (!/^[A-Za-z\s]+$/.test(fullName)) {
            document.getElementById('full_name_error').textContent = "Please enter a valid name.";
            isValid = false;
        }

        // Email format check
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            document.getElementById('email_error').textContent = "Invalid email format.";
            isValid = false;
        }

        // Phone number: exactly 10 digits
        if (!/^\d{10}$/.test(contact)) {
            document.getElementById('contact_error').textContent = "Phone number must be 10 digits.";
            isValid = false;
        }

        // NIC: either 9 digits + 'V' or 12 digits
        if (!/^(\d{9}[Vv]|\d{12})$/.test(nic)) {
            document.getElementById('nic_error').textContent = "NIC must be 9 digits + 'V' or 12 digits.";
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault(); // Prevent form submission if validation fails
        }
    });
</script>
</html>