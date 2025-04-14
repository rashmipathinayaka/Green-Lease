<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Worker Dashboard</title>
		<link rel="stylesheet" href="<?= URLROOT; ?>/assets/css/worker.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
		<!-- <script src="worker.js" defer></script> -->
	</head>
	<body>

	<?php
require ROOT . '/views/worker/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>

		<div class="admin-container">
			<div class="content">
				<div id="dashboard-section" class="section">
					<div class="worker-events-container">
						<div class="worker-events-header">
							<h2><i class="fas fa-calendar-check"></i> Available Events</h2>
							<span class="current-date"><?= date("F j, Y") ?></span>
						</div>
						<div class="worker-events-list">
							<!-- Event Cards -->
							<div class="worker-event-card">
								<div class="worker-event-icon">
									<i class="fas fa-leaf"></i>
								</div>
								<div class="worker-event-details">
									<div class="worker-event-header">
										<h3>Land Clearing</h3>
									</div>
									<div class="worker-event-info">
										<span><i class="fas fa-clock"></i> 09:00 AM</span>
										<span><i class="fas fa-map-pin"></i> Field A, No. 12, Green Valley Road</span>
										<span><i class="fas fa-user"></i> Ruwan Fernando</span>
									</div>
								</div>
								<div class="worker-event-actions">
									<button class="green-btn">Apply</button>
									<button class="red-btn">Remove</button>
								</div>
							</div>
							<div class="worker-event-card">
								<div class="worker-event-icon">
									<i class="fas fa-vial"></i>
								</div>
								<div class="worker-event-details">
									<div class="worker-event-header">
										<h3>Soil Testing</h3>
									</div>
									<div class="worker-event-info">
										<span><i class="fas fa-clock"></i> 11:00 AM</span>
										<span><i class="fas fa-map-pin"></i> Lab 1, No. 45, Orchard Street</span>
										<span><i class="fas fa-user"></i> Priyanka Silva</span>
									</div>
								</div>
								<div class="worker-event-actions">
									<button class="green-btn">Apply</button>
									<button class="red-btn">Remove</button>
								</div>
							</div>
							<div class="worker-event-card">
								<div class="worker-event-icon">
									<i class="fas fa-seedling"></i>
								</div>
								<div class="worker-event-details">
									<div class="worker-event-header">
										<h3>Fertilizing</h3>
									</div>
									<div class="worker-event-info">
										<span><i class="fas fa-clock"></i> 01:00 PM</span>
										<span><i class="fas fa-map-pin"></i> Field B, No. 89, Sunset Avenue</span>
										<span><i class="fas fa-user"></i> Saman Kumara</span>
									</div>
								</div>
								<div class="worker-event-actions">
									<button class="green-btn">Apply</button>
									<button class="red-btn">Remove</button>
								</div>
							</div>
							<div class="worker-event-card">
								<div class="worker-event-icon">
									<i class="fas fa-seedling"></i>
								</div>
								<div class="worker-event-details">
									<div class="worker-event-header">
										<h3>Seed Sowing</h3>
									</div>
									<div class="worker-event-info">
										<span><i class="fas fa-clock"></i> 03:00 PM</span>
										<span><i class="fas fa-map-pin"></i> Field C, No. 7, Maple Lane</span>
										<span><i class="fas fa-user"></i> Nuwan Perera</span>
									</div>
								</div>
								<div class="worker-event-actions">
									<button class="green-btn">Apply</button>
									<button class="red-btn">Remove</button>
								</div>
							</div>
							<div class="worker-event-card">
								<div class="worker-event-icon">
									<i class="fas fa-tractor"></i>
								</div>
								<div class="worker-event-details">
									<div class="worker-event-header">
										<h3>Harvesting</h3>
									</div>
									<div class="worker-event-info">
										<span><i class="fas fa-clock"></i> 05:00 PM</span>
										<span><i class="fas fa-map-pin"></i> Field D, No. 23, Sunshine Road</span>
										<span><i class="fas fa-user"></i> Chaminda Karunaratne</span>
									</div>
								</div>
								<div class="worker-event-actions">
									<button class="green-btn">Apply</button>
									<button class="red-btn">Remove</button>
								</div>
							</div>
							<div class="worker-event-card">
								<div class="worker-event-icon">
									<i class="fas fa-box"></i>
								</div>
								<div class="worker-event-details">
									<div class="worker-event-header">
										<h3>Processing the Harvest</h3>
									</div>
									<div class="worker-event-info">
										<span><i class="fas fa-clock"></i> 07:00 PM</span>
										<span><i class="fas fa-map-pin"></i> Processing Unit, No. 5, Industrial Park</span>
										<span><i class="fas fa-user"></i> Kusal Jayawardena</span>
									</div>
								</div>
								<div class="worker-event-actions">
									<button class="green-btn">Apply</button>
									<button class="red-btn">Remove</button>
								</div>
							</div>
							<div class="worker-event-card">
								<div class="worker-event-icon">
									<i class="fas fa-broom"></i>
								</div>
								<div class="worker-event-details">
									<div class="worker-event-header">
										<h3>Weeding</h3>
									</div>
									<div class="worker-event-info">
										<span><i class="fas fa-clock"></i> 08:00 AM</span>
										<span><i class="fas fa-map-pin"></i> Field E, No. 37, Evergreen Lane</span>
										<span><i class="fas fa-user"></i> Ashoka Rathnayake</span>
									</div>
								</div>
								<div class="worker-event-actions">
									<button class="green-btn">Apply</button>
									<button class="red-btn">Remove</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</body>
</html>