<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Project Events</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/supervisor/event.css">
</head>

<body>

<?php

require ROOT . '/views/admin/sidebar.php';
require ROOT . '/views/components/topbar.php';

?>

<h1 font face='green'>Projects of the Zone</h1><br><br><br>


<div id="completed-projects">
    <div class="projects-grid">
        <?php if (!empty($project)) : ?>
            <?php foreach ($project as $item) : ?>
                <div class="project-card">
                    <!-- Display the harvest image -->
                    <img src="<?php echo URLROOT; ?>/assets/images/hero.jpg" alt="Project Image" />

                    <!-- Display the site location -->
                    <p>Project ID: <?php echo htmlspecialchars($item->id); ?></p>

                    <!-- Display the crop type -->
                    <p>Crop Type: <?php echo htmlspecialchars($item->crop_type); ?></p>
                    <p>Remaining amount(kg): <?php echo htmlspecialchars($item->rem_amount); ?></p>

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