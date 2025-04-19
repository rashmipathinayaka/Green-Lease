<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/components/sidebar.css">

	<title>Document</title>
</head>
<body>
    <!-- Hamburger Menu Toggle Button -->

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul>
            <li>
                <img src="<?= URLROOT ?>/assets/Images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/Supervisor/Index">Dashboard</a>
            </li>
            <li>
                <img src="<?= URLROOT ?>/assets/Images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/Supervisor/Manage_fertilizer">Manage Fertilizer</a>
            </li>
			<li>
                <img src="<?= URLROOT ?>/assets/Images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/Supervisor/Manage_sitehead">Manage Site Heads</a>
            </li>
            
            <li>
                <img src="<?= URLROOT ?>/assets/Images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/Supervisor/ManageIssues">Manage Issues</a>
            </li>
			<li>
                <img src="<?= URLROOT ?>/assets/Images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/Supervisor/Attendance">Attendance</a></li>

            </li>
            <li>
                <img src="<?= URLROOT ?>/assets/Images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/Supervisor/Event">Event Schedule</a>

            </li>
			
				 <li>
                <img src="<?= URLROOT ?>/assets/Images/logout.png" alt="Logout Icon" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/logout">Log Out</a>
                </li>
        </ul>

        

    </div>

    <button class="menu-btn" onclick="toggleSidebar()">☰</button>
    <!-- JavaScript for Sidebar Toggle -->
    <script>
        function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("active");
}

    </script>
</body>
</html>