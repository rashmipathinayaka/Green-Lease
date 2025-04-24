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

<div id="full-section">
    <br>
<div id="procount-section">
    <form method="GET"  action="<?= URLROOT ?>/Admin/site_visit/<?= $land_id ?>" class="filter-form" style="margin-bottom: 20px; text-align: center;">
    <label for="name">  <h4>Enter the maximum number of projects for a supervisor:</h4>
        </label>
    <input type="number" name="procount" id="procount" min="1" value="<?= isset($_GET['procount']) ? htmlspecialchars($_GET['procount']) : '5' ?>">

	<button type="submit">Enter</button>
            </form>
</div>
<h3>Landowner of this land has already given a preferred date range for the site visit:</h3>
<p><?= $from_date . ' to ' . $to_date; ?></p>

    <div id="register-lands-section">

            <br><br>
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
                                     ...............  No of projects <?=htmlspecialchars($supervisor->procount)?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No supervisors available</option>
                        <?php endif; ?>
                    </select>





                    <label for="doc">Date-range for the visit</label>
<input type="text" id="from_date" name="from_date" disabled  value="<?php echo $from_date ?>">
<input type="text" id="to_date" name="to_date" disabled value="<?php echo $to_date ?>"">

<button class="form-submit-btn" type="submit">
    <i class="fas fa-paper-plane"></i>&nbsp;Submit</button>

                </div></form>
        </div>
    </div>
</div>
</body>

</html>