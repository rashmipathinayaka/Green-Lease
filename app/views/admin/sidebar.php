<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= URLROOT; ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Admin Dashboard</title>
</head>
<body>
<div class="sidebar">
    <div class="sidebar-header">
        <!-- <h3>Admin Portal</h3> -->
    </div>

    <nav class="sidebar-nav">
        <ul>
            <li class="<?= $currentPage === 'index.view.php' ? 'active' : '' ?>">
                <a href="<?= URLROOT ?>/Admin/index">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?= $currentPage === 'manage_bids.view.php' ? 'active' : '' ?>">
                <a href="<?= URLROOT ?>/Admin/manage_bids">
                    <i class="fas fa-gavel"></i>
                    <span>Manage Bids</span>
                </a>
            </li>
            <li class="<?= $currentPage === 'manage_buyer.view.php' ? 'active' : '' ?>">
                <a href="<?= URLROOT ?>/Admin/manage_buyer">
                    <i class="fas fa-users"></i>
                    <span>Manage Buyers</span>
                </a>
            </li>
            <li class="<?= $currentPage === 'manage_supervisor.view.php' ? 'active' : '' ?>">
                <a href="<?= URLROOT ?>/Admin/manage_supervisor">
                    <i class="fas fa-user-tie"></i>
                    <span>Manage Supervisors</span>
                </a>
            </li>
            <li class="<?= $currentPage === 'Manage_sitehead.view.php' ? 'active' : '' ?>">
                <a href="<?= URLROOT ?>/Admin/Manage_sitehead">
                    <i class="fas fa-user-shield"></i>
                    <span>Manage Siteheads</span>
                </a>
            </li>
            <li class="<?= $currentPage === 'Manage_worker.view.php' ? 'active' : '' ?>">
                <a href="<?= URLROOT ?>/Admin/Manage_worker">
                    <i class="fas fa-hard-hat"></i>
                    <span>Manage Workers</span>
                </a>
            </li>
            <li class="<?= $currentPage === 'Manage_land.view.php' ? 'active' : '' ?>">
                <a href="<?= URLROOT ?>/Admin/Manage_land">
                    <i class="fas fa-tractor"></i>
                    <span>Manage Projects</span>
                </a>
            </li>
            <li class="<?= $currentPage === 'Pending_approval.view.php' ? 'active' : '' ?>">
                <a href="<?= URLROOT ?>/Admin/Pending_approval">
                    <i class="fas fa-clock"></i>
                    <span>Pending Approvals</span>
                </a>
            </li>
            <li class="<?= $currentPage === 'marketplace.view.php' ? 'active' : '' ?>">
                <a href="<?= URLROOT ?>/Marketplace">
                    <i class="fas fa-store"></i>
                    <span>Marketplace</span>
                </a>
            </li>
            <li class="<?= $currentPage === 'manage_inquiry.view.php' ? 'active' : '' ?>">
                <a href="<?= URLROOT ?>/Admin/manage_inquiry">
                    <i class="fas fa-question-circle"></i>
                    <span>Manage Inquiries</span>
                </a>
            </li>
            <li class="<?= $currentPage === 'feedback.view.php' ? 'active' : '' ?>">
                <a href="<?= URLROOT ?>/Admin/feedback">
                    <i class="fas fa-comment-alt"></i>
                    <span>Manage Feedbacks</span>
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

.sidebar-footer {
    padding: 20px;
    margin-bottom: -20px;
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