<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Site Head Dashboard</title>
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/sitehead.css">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> -->
	<script src="sitehead.js" defer></script>
</head>

<body>
	<?php
	require ROOT . '/views/sitehead/sidebar.php';
	require ROOT . '/views/components/topbar.php';
	?>
	<div class="admin-container">


		<div class="content">
			<div id="dashboard-section" class="section">
				<div class="metric-grid">
					<div class="metric-card">
						<h3>Worker Count</h3>
						<div class="metric-content">
							<span class="metric-value">20</span>
							<i class="fas fa-user"></i>
						</div>
						<button onclick="showSection('manage-workers-section')">View</button>
					</div>

					<div class="metric-card">
						<h3>Upcoming Events Count</h3>
						<div class="metric-content">
							<span class="metric-value">10</span>

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
						<?php if (!empty($todaysEvents)) : ?>
							<?php foreach ($todaysEvents as $event) : ?>
								<div class="event-card <?= $event->status == 1 ? 'high-priority' : 'medium-priority' ?>"
									onclick="window.location.href='<?= URLROOT ?>/sitehead/Event/details/<?= $event->id ?>'">
									<div class="event-icon">
										<i class="fas fa-calendar-day"></i>
									</div>
									<div class="event-details">
										<div class="event-header">
											<h3><?= htmlspecialchars($event->event_name) ?></h3>
											<span class="priority-badge">
												<?= $event->status == 1 ? 'High Priority' : 'Medium Priority' ?>
											</span>
										</div>
										<div class="event-info">
											<span><i class="fas fa-clock"></i> <?= date('h:i A', strtotime($event->date)) ?></span>
											<span><i class="fas fa-leaf"></i> <?= htmlspecialchars($event->crop_type) ?></span>
											<span><i class="fas fa-align-left"></i> <?= htmlspecialchars(substr($event->description, 0, 200)) ?>...</span>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						<?php else : ?>
							<div class="no-events">
								<i class="fas fa-calendar-times"></i>
								<p>No events scheduled for today</p>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>





		</div>
	</div>
</body>

</html>