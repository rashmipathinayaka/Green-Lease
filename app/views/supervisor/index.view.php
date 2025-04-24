

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Supervisor Dashboard</title>
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/supervisor.css">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/supervisor/view.css">


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<script src="<?php echo URLROOT; ?>/assets/JS/view.js" defer></script>
</head>

<body>
	<?php
	require ROOT . '/views/supervisor/sidebar.php';
	require ROOT . '/views/components/topbar.php';
	?>

	<div class="admin-container">


		<div class="content">
			<div id="dashboard-section" class="section">
			<div class="metric-grid">
    <div class="metric-card">
        <h3>Ongoing Projects</h3>
        <div class="metric-content">
            <span class="metric-value"><?= $ongoingCount?></span>
            <i class="fas fa-hourglass-start"></i>
        </div>
    </div>
    <div class="metric-card">
        <h3>Completed Projects</h3>
        <div class="metric-content">
            <span class="metric-value"><?= $completedCount ?></span>
            <i class="fas fa-check-circle"></i>
        </div>
    </div>
</div>

<!-- Ongoing Projects -->
<h2>Ongoing Projects</h2>
<?php if (!empty($projects)): ?>
    <?php foreach ($projects as $project): ?>
        <?php if ($project->status == 1): ?> <!-- CORRECTED -->
            <div class="project-card">
                <p><strong>Project ID:</strong> <?= $project->id ?></p>
                <p><strong>Crop Type:</strong> <?= $project->crop_type ?></p>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>No ongoing projects found.</p>
<?php endif; ?>



<h2>Completed Projects</h2>
<?php if (!empty($projects)): ?>
    <?php foreach ($projects as $project): ?>
        <?php if ($project->status == 0): ?> <!-- CORRECTED -->
            <div class="project-card">
                <p><strong>Project ID:</strong> <?= $project->id ?></p>
                <p><strong>Crop Type:</strong> <?= $project->crop_type ?></p>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>No completed projects found.</p>
<?php endif; ?>




			<!-- Modal Structure -->
<div id="modal-overlay" class="modal-overlay">
	<div class="modal-content">
		<span class="close-button" onclick="closeModal()">&times;</span>
		<div id="modal-body">
			<!-- Dynamic content goes here -->
		</div>
	</div>
</div>









		</div>
	</div>
</body>

</html>