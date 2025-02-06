<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/landowner/index.css">

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
                            <span class="metric-value">5</span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button>View</button>
                    </div>
                    <div class="metric-card">
                        <h2>Ongoing Projects</h2>
                        <div class="metric-content">
                            <span class="metric-value">3</span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button>View</button>
                    </div>
                    <div class="metric-card">
                        <h2>Completed Projects</h2>
                        <div class="metric-content">
                            <span class="metric-value">1</span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button>View</button>
                    </div>
                    <div class="metric-card">
                        <h2>Unused Lands</h2>
                        <div class="metric-content">
                            <span class="metric-value">1</span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button>View</button>
                    </div>
                </div>

                <h1>Ongoing Projects</h1><br><br>

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
</body>
</html>