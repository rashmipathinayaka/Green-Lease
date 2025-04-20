<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Supervisor Dashboard</title>
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/supervisor.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<script src="supervisor.js" defer></script>
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
							<h3>Lands in the Zone</h3>
							<div class="metric-content">
								<span class="metric-value">15</span>
								<i class="fas fa-seedling"></i>
							</div>
							<button onclick="showSection('manage-lands-section')">View</button>
						</div>
						<div class="metric-card">
							<h3>Workers in the Zone</h3>
							<div class="metric-content">
								<span class="metric-value">30</span>
								<i class="fas fa-user"></i>
							</div>
							<button onclick="showSection('manage-supervisors-section')">View</button>
						</div>
					</div>
					<center>
						<h1>Ongoing Projects</h1>
					</center>
					<br>
					<div class="projects-grid">
						<div class="project-card">
						<img src="<?php echo URLROOT; ?>/assets/Images/hero.jpg" alt="Project Image" />

							<p>Site Location</p>
							<p>Crop Type</p>
						</div>
						<div class="project-card">
						<img src="<?php echo URLROOT; ?>/assets/Images/hero.jpg" alt="Project Image" />
							<p>Site Location</p>
							<p>Crop Type</p>
						</div>
						<div class="project-card">
						<img src="<?php echo URLROOT; ?>/assets/Images/hero.jpg" alt="Project Image" />
							<p>Site Location</p>
							<p>Crop Type</p>
						</div>
					</div>
				</div>
				<!-- Manage Fertilizer Section -->
				
				<!-- </div> -->
				
				
				
				
				




		</div>
	</div>
</body>

</html>