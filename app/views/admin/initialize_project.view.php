<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin/project.css">

    <title>Green & White Form</title>

</head>

<body>
    <?php $showBigForm = $data['showBigForm'] ?? false; ?>

    <div class="form-container">
        <div class="info">
            Kindly complete all fields below using the specific details contained in the crop_type
            from the Zone Supervisor. Upon verification and submission of this form, a new project will be
            initialized in our project management system for further action.</div>


        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="message success-message"><?php echo $_SESSION['success_message'];
                                                    unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>

        <?php if (!empty($data['message'])): ?>
            <div class="message error-message"><?php echo $data['message']; ?></div>
        <?php endif; ?>

        <h2></h2>

        <?php if (!$showBigForm): ?>
            <form action="<?= URLROOT ?>/Admin/initialize_project/" method="POST">
                <div class="lil-form">
                    <div class="form-group">
                        <label for="land_id">Land id</label>
                        <input type="number" id="land_id" name="land_id" required>
                    </div>
                    <button type="submit">Submit</button>
                </div>
            </form>
        <?php endif; ?>


        <?php if ($showBigForm): ?>
            <div class="big-form">
                <form action="<?= URLROOT ?>/Admin/initialize_project/" method="POST">
                    <div class="form-group">
                        <label for="crop_type">Crop type</label>
                        <div class="note">preferred crop of the landowner: <?php echo htmlspecialchars($landInfo->crop_type); ?>
                        </div>
                        <input type="text" id="crop_type" name="crop_type" required>
                    </div>

                    <div class="form-group">
                        <label for="duration">Duration of the project</label>
                        <input type="number" id="duration" name="duration" required>
                    </div>

                    <div class="form-group">
                        <label for="supervisor_id">Supervisor id</label>
                        <div class="note">Supervisor assigned for the site visit: <?php echo htmlspecialchars($supinfo->supervisor_id); ?>

                        <input type="number" id="supervisor_id" name="supervisor_id" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea id="message" name="message" rows="4"></textarea>
                    </div>

                    <button type="submit">Submit</button>
                </form>
            </div>
        <?php endif; ?>

        <div class="form-footer">
            Thank you for reaching out to us. We'll respond within 24 hours.
        </div>
    </div>


</body>

</html>