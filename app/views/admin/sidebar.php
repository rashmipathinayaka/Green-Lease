
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/sidebar.css">
    <title>Document</title>
</head>
<body>
    <!-- Hamburger Menu Toggle Button -->

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul>
            <li>
                <img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/Admin/index">Dashboard</a>
            </li>
            <li>
                <img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/Admin/manage_bids">Manage Bids</a>
            </li>
            <li>
                <img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/Admin/manage_buyers">Manage Buyers</a>
            </li>


            <li>
                <img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/Admin/manage_supervisor">Manage Supervisors</a>
            </li>

            <li>
                <img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/Admin/Manage_sitehead">Manage Siteheads</a>
            </li>


            
            <li>
                <img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/Admin/Manage_worker">Manage Workers</a>
            </li>

            
            <li>
                <img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/Admin/Manage_land">Manage Lands</a>
            </li>


            <li>
                <img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/Admin/Pending_approval">Pending approvals</a>
            </li>

            <li>
                <img src="<?= URLROOT ?>/assets/images/leaf (3).png" alt="Green Lease Logo" class="menu-icon">
                <a href="<?php echo URLROOT; ?>/Marketplace">Marketplace</a>
            </li>
        </ul>

        <!-- Logout Section -->
        <ul class="logout">
            <li>
                <img src="<?= URLROOT ?>/assets/images/logout.png" alt="Logout Icon" class="menu-icon">
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