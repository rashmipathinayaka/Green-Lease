<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?= URLROOT; ?>/assets/css/buyer.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<title>Sitehead Dashboard</title>
</head>

<body>
	<!-- Hamburger Menu Toggle Button -->

	<!-- Sidebar -->
	<div class="sidebar">
		<div class="sidebar-header">
			<!-- <h3>Sitehead Portal</h3> -->
		</div>

		<nav class="sidebar-nav">
			<ul>
				<li class="<?= $currentPage === 'index.view.php' ? 'active' : '' ?>">
					<a href="<?= URLROOT ?>/Sitehead/index">
						<i class="fas fa-home"></i>
						<span>Dashboard</span>
					</a>
				</li>
				<li class="<?= $currentPage === 'Manage_worker.view.php' ? 'active' : '' ?>">
					<a href="<?= URLROOT ?>/Sitehead/Manage_worker">
						<i class="fas fa-users"></i>
						<span>Manage Workers</span>
					</a>
				</li>
				<li class="<?= $currentPage === 'Manage_fertilizer.view.php' ? 'active' : '' ?>">
					<a href="<?= URLROOT ?>/Sitehead/Manage_fertilizer">
						<i class="fas fa-seedling"></i>
						<span>Request Fertilizers</span>
					</a>
				</li>
				<li class="<?= $currentPage === 'requests.view.php' ? 'active' : '' ?>">
					<a href="<?= URLROOT ?>/Sitehead/Manage_fertilizer/requests">
						<i class="fas fa-clipboard-list"></i>
						<span>Fertilizer Requests</span>
					</a>
				</li>
				<li class="<?= $currentPage === 'ReportIssue.view.php' ? 'active' : '' ?>">
					<a href="<?= URLROOT ?>/Sitehead/ReportIssue">
						<i class="fas fa-exclamation-triangle"></i>
						<span>Report an Issue</span>
					</a>
				</li>
				<li class="<?= $currentPage === 'feedback.view.php' ? 'active' : '' ?>">
					<a href="<?= URLROOT ?>/sitehead/feedback">
						<i class="fas fa-comments"></i>
						<span>Manage Feedbacks</span>
					</a>
				</li>
                <li class="<?= $currentPage === 'harvest.view.php' ? 'active' : '' ?>">
					<a href="<?= URLROOT ?>/sitehead/harvest">
						<i class="fas fa-shopping-cart"></i>
						<span>Purchases</span>
					</a>
				</li>
			</ul>
		</nav>

		<div class="sidebar-footer">
			<a href="<?= URLROOT ?>/Logout" class="logout-btn">
				<i class="fas fa-sign-out-alt"></i>
				<span>Logout</span>
			</a>
		</div>
	</div>

	<!-- <button class="menu-btn" onclick="toggleSidebar()">☰</button> -->
	<!-- JavaScript for Sidebar Toggle -->
	<script>
		function toggleSidebar() {
			const sidebar = document.getElementById("sidebar");
			sidebar.classList.toggle("active");
		}
	</script>

	<style>
		.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    width: 250px;
    background: linear-gradient(180deg, #1a472a 0%, #2e7d32 100%);
    color: white;
    padding: 20px 0;
    display: flex;
    flex-direction: column;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.sidebar-header {
    padding: 0 20px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    text-align: center;
    margin-bottom: 30px;
}

.sidebar-logo {
    width: 80px;
    height: 80px;
    margin-bottom: 10px;
    border-radius: 50%;
    padding: 5px;
    background: rgba(255, 255, 255, 0.1);
}

.sidebar-header h3 {
    font-size: 1.2rem;
    font-weight: 600;
    color: white;
}

.sidebar-nav {
    flex: 1;
    padding: 20px 0;
    overflow-y: auto;
}

.sidebar-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-nav li {
    margin: 5px 0;
}

.sidebar-nav a {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
}

.sidebar-nav a:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
}

.sidebar-nav li.active a {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border-left: 4px solid #fff;
}

.sidebar-nav i {
    width: 24px;
    font-size: 1.1rem;
    margin-right: 10px;
}

.notification-badge {
    background: #ff4757;
    color: white;
    padding: 2px 6px;
    border-radius: 10px;
    font-size: 0.7rem;
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
}

.sidebar-footer {
    padding: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.logout-btn {
    display: flex;
    align-items: center;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    padding: 10px;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.logout-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
}

.logout-btn i {
    margin-right: 10px;
}

@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }

    .sidebar.active {
        transform: translateX(0);
    }
}
	</style>
</body>

</html>