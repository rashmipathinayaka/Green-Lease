<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin/manage-bids.css">

    <title>Document</title>
</head>

<body style="margin-top: 50px; margin-left: 20px; margin-right: 20px;">

    <?php

    require ROOT . '/views/admin/sidebar.php';
    require ROOT . '/views/components/topbar.php';

    ?>

    <center>
        <h1>Upcoming Harvests</h1>
    </center>
    <br><br>


    <div id="completed-projects">
        <div class="projects-grid">
            <?php if (!empty($harvest)) : ?>
                <?php foreach ($harvest as $item) : ?>
                    <div class="project-card">
                        <!-- Display the harvest image -->
                        <img src="<?php echo URLROOT; ?>/assets/images/hero.jpg" alt="Project Image" />

                        <!-- Display the site location -->
                        <p>Site Location: <?php echo htmlspecialchars($item->id); ?></p>

                        <!-- Display the crop type -->
                        <p>Expected Amount (KG): <?php echo htmlspecialchars($item->max_amount); ?></p>
                        <p>Remaining Amount (KG): <?php echo htmlspecialchars($item->rem_amount); ?></p>

                        <!-- Display additional harvest details if needed -->
                        <p>Harvest Date: <?php echo htmlspecialchars($item->harvest_date); ?></p>
                        <form action="<?= URLROOT ?>/Admin/Bidding" method="POST">
                            <input type="hidden" name="harvest_id" value="<?php echo $item->id; ?>">
                            <button type="submit" class="bidding">View All Biddings</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No harvest data found.</p>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>