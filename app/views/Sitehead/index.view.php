<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Site Head Dashboard</title>
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/sitehead.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<script src="sitehead.js" defer></script>
</head>

<body>
	<?php
	require ROOT . '/views/sitehead/sidebar.php';
	require ROOT . '/views/components/navbar.php';
	?>
	<div class="admin-container">


		<div class="content">
			<div id="dashboard-section" class="section">
				<div class="metric-grid">
					<div class="metric-card">
						<h3>Worker Count</h3>
						<div class="metric-content">
							<span class="metric-value">15</span>
							<i class="fas fa-user"></i>
						</div>
						<button onclick="showSection('manage-workers-section')">View</button>
					</div>

					<div class="metric-card">
						<h3>Buyer Count</h3>
						<div class="metric-content">
							<span class="metric-value">240</span>
							<i class="fas fa-user"></i>
						</div>
						<button onclick="showSection('manage-buyers-section')">View</button>
					</div>
				</div>
				<div class="events-container">
					<div class="events-header">
						<h2><i class="fas fa-calendar-day"></i> Today's Events</h2>
						<span class="current-date"><?= date("F j, Y") ?></span>
					</div>
					<div class="events-list">
						<div class="event-card high-priority">
							<div class="event-icon">
								<i class="fas fa-map-marker-alt"></i>
							</div>
							<div class="event-details">
								<div class="event-header">
									<h3>Soil Inspection</h3>
									<span class="priority-badge">High Priority</span>
								</div>
								<div class="event-info">
									<span><i class="fas fa-clock"></i> 09:00 AM</span>
									<span><i class="fas fa-map-pin"></i> Rice Field Block A</span>
									<span><i class="fas fa-user"></i> Yasitha Vas</span>
								</div>
							</div>
						</div>
						<div class="event-card medium-priority">
							<div class="event-icon">
								<i class="fas fa-truck"></i>
							</div>
							<div class="event-details">
								<div class="event-header">
									<h3>Fertilizer Delivery</h3>
									<span class="priority-badge">Medium Priority</span>
								</div>
								<div class="event-info">
									<span><i class="fas fa-clock"></i> 10:30 AM</span>
									<span><i class="fas fa-map-pin"></i> Warehouse 2</span>
									<span><i class="fas fa-user"></i> Samantha Perera</span>
								</div>
							</div>
						</div>
						<div class="event-card high-priority">
							<div class="event-icon">
								<i class="fas fa-users"></i>
							</div>
							<div class="event-details">
								<div class="event-header">
									<h3>Buyer Meeting</h3>
									<span class="priority-badge">High Priority</span>
								</div>
								<div class="event-info">
									<span><i class="fas fa-clock"></i> 02:00 PM</span>
									<span><i class="fas fa-map-pin"></i> Conference Room</span>
									<span><i class="fas fa-user"></i> Prabath Jayasinghe</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>





		</div>
	</div>
</body>

</html>