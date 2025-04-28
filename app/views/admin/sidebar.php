<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <!-- Hamburger Menu Toggle Button -->

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar" >
        <ul >
            <li>
                <a href="<?php echo URLROOT; ?>/Admin/index">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li> 
                <a href="<?php echo URLROOT; ?>/Admin/manage_bids">
                    <i class="fas fa-gavel"></i> Manage Bids
                </a>
            </li>
            <li>
                <a href="<?php echo URLROOT; ?>/Admin/manage_buyer">
                    <i class="fas fa-users"></i> Manage Buyers
                </a>
            </li>

            <li>
                
                <a href="<?php echo URLROOT; ?>/Admin/manage_supervisor">
                    <i class="fas fa-user-tie"></i> Manage Supervisors
                </a>
            </li>

            <li>
                
                <a href="<?php echo URLROOT; ?>/Admin/Manage_sitehead">
                    <i class="fas fa-user-shield"></i> Manage Siteheads
                </a>
            </li>


            
            <li>
                <a href="<?php echo URLROOT; ?>/Admin/Manage_worker">
                    <i class="fas fa-hard-hat"></i> Manage Workers
                </a>
            </li>

            
            <li>
                <a href="<?php echo URLROOT; ?>/Admin/Manage_land">
                    <i class="fas fa-tractor"></i> Manage Lands
                </a>
            </li>


            <li>
                <a href="<?php echo URLROOT; ?>/Admin/Pending_approval">
                    <i class="fas fa-clock"></i> Pending approvals
                </a>
            </li>

            <li>
                <a href="<?php echo URLROOT; ?>/Marketplace">
                    <i class="fas fa-store"></i> Marketplace
                </a>
            </li>

            <li>
                <a href="<?php echo URLROOT; ?>/Admin/manage_inquiry">
                    <i class="fas fa-question-circle"></i> Manage Inquiries
                </a>
            </li>

            <li>
                <a href="<?php echo URLROOT; ?>/Admin/feedback">
                    <i class="fas fa-comment-alt"></i> Manage Feedbacks
                </a>
            </li>

        </ul>

        <!-- Logout Section -->
        <ul class="logout">
            <li>
                <a href="<?php echo URLROOT; ?>/logout">
                    <i class="fas fa-sign-out-alt"></i> Log Out
                </a>
                </li>
        </ul>

    </div>

    <!-- <button class="menu-btn" onclick="toggleSidebar()">☰</button> -->
    <!-- JavaScript for Sidebar Toggle -->
    <script>
        function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("active");
}

    </script>
</body>
</html>