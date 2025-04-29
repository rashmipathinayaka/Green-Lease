<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/buyer.css">
    <title>Document</title>
</head>
<body>
    <!-- Hamburger Menu Toggle Button -->

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul>
            <li>
                <a href="<?php echo URLROOT; ?>/Landowner/index">Dashboard</a>
            </li>
            <li>
                <a href="<?php echo URLROOT; ?>/Landowner/registerland">Register a Land</a>
            </li>
            <li>
                <a href="<?php echo URLROOT; ?>/Landowner/manageland">Manage Lands</a>
            </li>
            <li>
                <a href="<?php echo URLROOT; ?>/marketplace">Marketplace</a>
            </li>
        </ul>

        <!-- Logout Section -->
        <ul class="logout">
            <li>
                <a href="<?php echo URLROOT; ?>/logout">Log Out</a>
                </li>
        </ul>

    </div>

    <!-- JavaScript for Sidebar Toggle -->
    <script>
        function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("active");
}

    </script>
</body>
</html>