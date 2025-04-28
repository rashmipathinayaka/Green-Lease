<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/landowner/registerlands.css">
    <title>add supervisor</title>
</head>

<body>

    <?php

    require ROOT . '/views/components/topbar.php';

    ?>



    <div id="register-lands-section" class="section">
        <div class="form-container">
            <h1 class="register-topic">Fill in supervisor details</h1>
            <br>
            <form class="form" action="<?= URLROOT ?>/Admin/add_supervisor" method="POST"
                enctype="multipart/form-data" novalidate>
                <div class="form-group">
                    <!-- Add this below each input -->
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" required>
                    <span class="error" id="full_name_error"></span>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <span class="error" id="email_error"></span>

                    <label for="contact_no">Phone Number:</label>
                    <input type="number" id="contact_no" name="contact_no" required>
                    <span class="error" id="contact_error"></span>

                    <label for="nic">NIC:</label>
                    <input type="number" id="nic" name="nic" required>
                    <span class="error" id="nic_error"></span>
 
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




                    <button class="form-submit-btn" type="submit">
                        <i class="fas fa-paper-plane"></i>&nbsp;Submit
                    </button>

                    <br>
                    <center> <button class="black-btn" onclick="window.location.href='<?= URLROOT ?>/Admin/manage_supervisor/'">Go back</button></center>



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

        // Full name check (letters and spaces only)
        if (!/^[A-Za-z\s]+$/.test(fullName)) {
            document.getElementById('full_name_error').textContent = "Please enter a valid name.";
            isValid = false;
        }

        // Email format
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            document.getElementById('email_error').textContent = "Invalid email format.";
            isValid = false;
        }

        // Phone number: 10 digits
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
            e.preventDefault(); // Stop form submission
        }
    });
</script>


</html>