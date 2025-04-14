<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/landowner/registerlands.css">
    <title>Register Land</title>
</head>

<body>
    <?php

    require ROOT . '/views/admin/sidebar.php';
    require ROOT . '/views/components/topbar.php';

    ?>

    <div id="register-lands-section" class="section">
        <div class="form-container">
            <h1 class="register-topic">Schedule a site visit</h1>
            <br>
            <form class="form" action="<?= URLROOT ?>/admin/site_visit" method="POST"
                enctype="multipart/form-data">
                <div class="form-group">

                <input type="hidden" name="land_id" value="<?= $land_id ?>">

                    <select name="supervisor_id" id="supervisor_id" required>
                        <option value="" disabled selected hidden>Select supervisor</option>
                        <?php if (!empty($supervisors)): ?>
                            <?php foreach ($supervisors as $supervisor): ?>
                                <option value="<?= htmlspecialchars($supervisor->id) ?>">
                                    Supervisor <?= htmlspecialchars($supervisor->id) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No supervisors available</option>
                        <?php endif; ?>
                    </select>










                    <label for="doc">Date for the visit</label>
                    <input type="date" id="date" name="date" required>
                    <button class="form-submit-btn" type="submit">
                        <i class="fas fa-paper-plane"></i>&nbsp;Submit</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>