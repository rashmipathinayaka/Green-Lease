<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/supervisor.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/supervisor/view.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="<?php echo URLROOT; ?>/assets/JS/view.js" defer></script>
</head>

<body>
    <?php
    require ROOT . '/views/supervisor/sidebar.php';
    require ROOT . '/views/components/topbar.php';
    ?>

    <div class="admin-container">
        <div class="content">
            <div id="dashboard-section" class="section">

                <div class="metric-grid">
                    <div class="metric-card">
                        <h2>Ongoing Projects</h2>
                        <div class="metric-content">
                            <span class="metric-value">
                                <?= isset($proCount) ? htmlspecialchars($proCount) : '0' ?>
                            </span>
                            <i class="fas fa-user"></i>
                        </div>
                        <a href="#ongoing-projects" style="text-decoration: none;">
                            <button>View</button>
                        </a>
                    </div>

                    <div class="metric-card">
                        <h2>Completed Projects</h2>
                        <div class="metric-content">
                            <span class="metric-value">
                                <?= isset($completedproCount) ? htmlspecialchars($completedproCount) : '0' ?>
                            </span>
                            <i class="fas fa-user"></i>
                        </div>
                        <a href="#completed-projects" style="text-decoration: none;">
                            <button>View</button>
                        </a>
                    </div>
                </div>

                <!-- Ongoing Projects -->
                <h1>Ongoing Projects</h1><br><br>

                <div id="ongoing-projects">
                    <div class="projects-grid">
                        <?php if (!empty($ongoingProjects)) : ?>
                            <?php foreach ($ongoingProjects as $project) : ?>
                                <div class="project-card">
                                    <img src="<?php echo URLROOT; ?>/assets/images/ongoing2.png" alt="Project Image" class="img" />
                                    <p>Project ID: <?php echo htmlspecialchars($project->id); ?></p>
                                    <p>Crop Type: <?php echo htmlspecialchars($project->crop_type); ?></p>
                                    
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>No Ongoing Projects found.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <br><br>

                <!-- Completed Projects -->
                <h1>Completed Projects</h1><br><br>

                <div id="completed-projects" class="c">
                    <div class="projects-grid">
                        <?php if (!empty($completedProjects)) : ?>
                            <?php foreach ($completedProjects as $item) : ?>
                                <div class="project-card">
                                    <img src="<?php echo URLROOT; ?>/assets/images/tick.png" alt="Project Image" />
                                    <p>Project ID: <?php echo htmlspecialchars($item->id); ?></p>
                                    <p>Crop Type: <?php echo htmlspecialchars($item->crop_type); ?></p>
                                    
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>No Completed projects found.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <br><br>

            </div>

            <!-- Modal Structure -->
            <div id="modal-overlay" class="modal-overlay">
                <div class="modal-content">
                    <span class="close-button" onclick="closeModal()">&times;</span>
                    <div id="modal-body">
                        <!-- Dynamic content goes here -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
