<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard | Green Lease</title>
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
                <!-- Dashboard Header -->
                <!-- Dashboard Header -->
<div class="dashboard-header">
    <h1 class="welcome-message" style="font-size: 42px !important; font-weight: 800 !important;">Welcome to Supervisor Dashboard</h1>
</div>



                <!-- Metric Cards -->
                <div class="metric-grid">
                    <div class="metric-card">
                        <h2><b>Ongoing Projects</b></h2>
                        <div class="metric-content">
                            <span class="metric-value">
                                <?= isset($proCount) ? htmlspecialchars($proCount) : '0' ?>
                            </span>
                            <i class="fas fa-seedling"></i>
                        </div>
                        <a href="#ongoing-projects" style="text-decoration: none;">
                            <button><i class="fas fa-eye"></i> View Details</button>
                        </a>
                    </div>

                    <div class="metric-card">
                        <h2><b>Completed Projects</b></h2>
                        <div class="metric-content">
                            <span class="metric-value">
                                <?= isset($completedproCount) ? htmlspecialchars($completedproCount) : '0' ?>
                            </span>
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <a href="#completed-projects" style="text-decoration: none;">
                            <button><i class="fas fa-eye"></i> View Details</button>
                        </a>
                    </div>
                </div>
                

                <!-- Ongoing Projects Section -->
                <div class="section-header">
                    <h1>Ongoing Projects</h1>
                </div>

                <div id="ongoing-projects">
                    <?php if (!empty($ongoingProjects)) : ?>
                        <div class="projects-grid">
                            <?php foreach ($ongoingProjects as $project) : ?>
                                <div class="project-card">
                                    <img src="<?php echo URLROOT; ?>/assets/images/hero2.jpg" alt="Project Image" />
                                    <div class="project-info">
                                        <h3 class="project-title"><?php echo htmlspecialchars($project->crop_type); ?></h3>
                                        <div class="project-detail">
                                            <i class="fas fa-hashtag"></i>
                                            <span>Project ID: <?php echo htmlspecialchars($project->id); ?></span>
                                        </div>
                                        <?php if (!empty($project->start_date)) : ?>
                                        <div class="project-detail">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>Started: <?php echo htmlspecialchars($project->start_date); ?></span>
                                        </div>
                                        <?php endif; ?>
                                        <span class="project-status status-ongoing">Ongoing</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="empty-state">
                            <i class="fas fa-seedling"></i>
                            <p>No ongoing projects found</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Completed Projects Section -->
                <div class="section-header">
                    <h1>Completed Projects</h1>
                </div>

                <div id="completed-projects">
                    <?php if (!empty($completedProjects)) : ?>
                        <div class="projects-grid">
                            <?php foreach ($completedProjects as $project) : ?>
                                <div class="project-card">
                                    <img src="<?php echo URLROOT; ?>/assets/images/hero2.jpg" alt="Project Image" />
                                    <div class="project-info">
                                        <h3 class="project-title"><?php echo htmlspecialchars($project->crop_type); ?></h3>
                                        <div class="project-detail">
                                            <i class="fas fa-hashtag"></i>
                                            <span>Project ID: <?php echo htmlspecialchars($project->id); ?></span>
                                        </div>
                                        <?php if (!empty($project->end_date)) : ?>
                                        <div class="project-detail">
                                            <i class="fas fa-flag-checkered"></i>
                                            <span>Completed: <?php echo htmlspecialchars($project->end_date); ?></span>
                                        </div>
                                        <?php endif; ?>
                                        <span class="project-status status-completed">Completed</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="empty-state">
                            <i class="fas fa-check-circle"></i>
                            <p>No completed projects yet</p>
                        </div>
                    <?php endif; ?>
                </div>
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

    <script>
        // Function to close modal
        function closeModal() {
            document.getElementById('modal-overlay').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('modal-overlay');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>

</html>
