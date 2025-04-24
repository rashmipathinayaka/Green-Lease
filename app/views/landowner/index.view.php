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
    require ROOT . '/views/components/topbar.php';

    ?>


    <div id="dashboard-section" class="section">

        <div class="welcome-container">
            <div class="welcome-header">
                <h1>Hello, <span class="username"><?= htmlspecialchars($user->full_name) ?></span> ! 👋</h1>
                <p class="welcome-message">Welcome back to your dashboard</p>
            </div>
        </div>


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

        <div id="completed-projects">
            <div class="projects-grid">
                <?php if (!empty($lands)) : ?>
                    <?php foreach ($lands as $land) : ?>
                        <div class="project-card">
                            <img src="<?php echo URLROOT; ?>/assets/images/ongoing2.png" alt="Project Image"  class="img"/>

                            <p>Project ID: <?php echo htmlspecialchars($land->id); ?></p>

                            <p>Crop Type: <?php echo htmlspecialchars($land->crop_type); ?></p>

                         
                            <a href="<?= URLROOT ?>/Components/Project/index/<?php echo $land->id; ?>"
                            class="view">View Project</a>



                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No harvest data found.</p>
                <?php endif; ?>
            </div>
        </div>

        <br><br> <br>





        <h1>Completed Projects</h1><br><br>

        <div id="completed-projects" class="c">
            <div class="projects-grid">
                <?php if (!empty($landz)) : ?>
                    <?php foreach ($landz as $item) : ?>
                        <div class="project-card">
                            <img src="<?php echo URLROOT; ?>/assets/images/tick.png" alt="Project Image" />

                            <p>Project ID: <?php echo htmlspecialchars($item->id); ?></p>

                            <p>Crop Type: <?php echo htmlspecialchars($item->crop_type); ?></p>

                            <!-- methena redirect wena eka hadanna-->


                            <a href="<?= URLROOT ?>/Components/Project/index/<?php echo $land->id; ?>"
                            class="view">View Project</a>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No harvest data found.</p>
                <?php endif; ?>
            </div>
        </div>

        <br><br> <br>


    </div>
</body>

</html>