<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/landowner/landowner.css">

    <title>Document</title>

</head>

<body>
    <?php

    require ROOT . '/views/landowner/sidebar.php';
    require ROOT . '/views/components/navbar.php';

    ?>


    <div id="dashboard-section" class="section">
        <div class="metric-grid">
            <div class="metric-card">
                <h2>Total Lands</h2>
                <div class="metric-content">
                    <span class="metric-value">
                        <?php echo !empty($landCount) ? htmlspecialchars($landCount) : 5; ?>
                    </span>
                    <i class="fas fa-user"></i>
                </div>
                <button onclick="window.location.href='<?= URLROOT ?>/Landowner/manageland/'">View</button>
            </div>

            
            <div class="metric-card">
                <h2>Ongoing Projects</h2>
                <div class="metric-content">
                    <span class="metric-value">
                        <?php echo !empty($proCount) ? htmlspecialchars($proCount) : 5; ?>
                    </span>
                    <i class="fas fa-user"></i>
                </div>
                <a href="#ongoing-projects" style="text-decoration: none;">
                    <button>View</button></a>
            </div>


            <div class="metric-card">
                <h2>Completed Projects</h2>
                <div class="metric-content">
                    <span class="metric-value">
                        <?php echo !empty($completedproCount) ? htmlspecialchars($completedproCount) : 5; ?>
                    </span>
                    <i class="fas fa-user"></i>
                </div>
                <a href="#completed-projects" style="text-decoration: none;">
                    <button>View</button></a>
            </div>


            <div class="metric-card">
                <h2>Unused Lands</h2>
                <div class="metric-content">
                    <span class="metric-value">
                        <?php echo !empty($inactivelandsCount) ? htmlspecialchars($inactivelandsCount) : 5; ?>
                    </span>
                    <i class="fas fa-user"></i>
                </div>
                <button onclick="window.location.href='<?= URLROOT ?>/Landowner/manageland/'">View</button>
            </div>
        </div>


        <h1>Ongoing Projects</h1><br><br>
        <div id="ongoing-projects">
            <div class="projects-grid">
                <div class="project-card">
                    <img src="<?php echo URLROOT; ?>/assets/images/hero.jpg" alt="Project Image" />
                    <p>Site Location</p>
                    <p>Crop Type</p>
                </div>
                <div class="project-card">
                    <img src="<?php echo URLROOT; ?>/assets/images/hero.jpg" alt="Project Image" />
                    <p>Site Location</p>
                    <p>Crop Type</p>
                </div>
                <div class="project-card">
                    <img src="<?php echo URLROOT; ?>/assets/images/hero.jpg" alt="Project Image" />
                    <p>Site Location</p>
                    <p>Crop Type</p>
                </div>
            </div>
        </div>
        <br><br> <br>
        <h1>Completed Projects</h1><br><br>

        <div id="completed-projects">
            <div class="projects-grid">
                <div class="project-card">
                    <img src="<?php echo URLROOT; ?>/assets/images/hero.jpg" alt="Project Image" />
                    <p>Site Location</p>
                    <p>Crop Type</p>
                </div>
                <div class="project-card">
                    <img src="<?php echo URLROOT; ?>/assets/images/hero.jpg" alt="Project Image" />
                    <p>Site Location</p>
                    <p>Crop Type</p>
                </div>
                <div class="project-card">
                    <img src="<?php echo URLROOT; ?>/assets/images/hero.jpg" alt="Project Image" />
                    <p>Site Location</p>
                    <p>Crop Type</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>