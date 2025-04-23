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
                enctype="multipart/form-data">
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" required>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <label for="contact_no">Phone Number:</label>
                    <input type="number" id="contact_no" name="contact_no" required>
                    <label for="nic">NIC:</label>
                    <input type="number" id="nic" name="nic" required>
                   

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
                    <input type="te" id="nic" name="nic" required>


                    <!-- <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="0">Active</option>
                        <option value="1">Inactive</option>
                    </select> -->



                   
                    <button class="form-submit-btn" type="submit" onclick="showCustomAlert()">
    <i class="fas fa-paper-plane"></i>&nbsp;Submit
</button>

<div id="customAlert" class="custom-alert">
    <span class="closebtn" onclick="closeAlert()">&times;</span>
    <strong>Success!</strong> Submission was successful.
</div><br>
                    <center> <button class="black-btn" onclick="window.location.href='<?= URLROOT ?>/Admin/manage_supervisor/'">Go back</button></center>

       

                </div>
            </form>
        </div>
    </div>
</body>
<script>
function showCustomAlert() {
    var alertBox = document.getElementById("customAlert");
    alertBox.classList.add("show");
}

function closeAlert() {
    var alertBox = document.getElementById("customAlert");
    alertBox.classList.remove("show");
}
</script>
</html>