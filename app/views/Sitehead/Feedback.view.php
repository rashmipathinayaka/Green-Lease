<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(URLROOT); ?>/assets/css/feedback.css">

    <title>Feedback Management System</title>

</head>

<body>

    <?php

    require ROOT . '/views/sitehead/sidebar.php';
    require ROOT . '/views/components/topbar.php';

    ?>


    <div class="container">
        <h1>Feedbacks and Issues Management</h1>

        <!-- Tabs -->
        <div class="tab-navigation">
            <button class="tab-btn active" onclick="openTab('unsolved')">Unsolved Feedbacks</button>
            <button class="tab-btn" onclick="openTab('solved')">Solved Feedbacks</button>
        </div>

        <!-- Unsolved Feedbacks Tab -->
        <div id="unsolved" class="tab-content active">
            <div class="feedback-section">
                <?php if (!empty($unsolved)): ?>
                    <?php foreach ($unsolved as $us): ?>
                        <div class="feedback-card">
                            <div class="feedback-header">
                                <div>
                                    <span class="from-user">From:
                                        <?php
                                        if ($us->role_id == 1) {
                                            echo "Admin";
                                        } elseif ($us->role_id == 2) {
                                            echo "Supervisor";
                                        } elseif ($us->role_id == 3) {
                                            echo "Site Head";
                                        } elseif ($us->role_id == 4) {
                                            echo "Landowner";
                                        } else {
                                            echo "Unknown Role";
                                        }
                                        ?>
                                    </span>
                                </div>
                                <div class="project-id">
                                    Project ID: <?php echo htmlspecialchars($us->project_id); ?>
                                    <a href="<?= URLROOT ?>/Components/Project/index/<?php echo htmlspecialchars($us->project_id); ?>" class="view-project">View</a>
                                </div>
                            </div>
                            <div class="feedback-content">
                                <?php echo htmlspecialchars($us->feedback); ?>
                            </div>
                            <div class="feedback-actions">
                                <form method="post" action="<?php echo htmlspecialchars(URLROOT); ?>/sitehead/Feedback/markSolved" onsubmit="return confirm('Are you sure you want to mark this feedback as solved?');">
                                    <input type="hidden" name="feedback_id" value="<?php echo htmlspecialchars($us->id); ?>">
                                    <button type="submit" name="mark_solved" class="button solve-button">Mark as Solved</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-feedback">No unsolved feedbacks found!</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Solved Feedbacks Tab -->
        <div id="solved" class="tab-content">
            <div class="feedback-section">
                <?php if (!empty($solved)): ?>
                    <?php foreach ($solved as $sl): ?>
                        <div class="feedback-card">
                            <div class="feedback-header">
                                <div>
                                    <span class="from-user">From: <?php echo htmlspecialchars($sl->feedback_user_id); ?></span>
                                </div>
                                <div class="project-id">
                                    Project ID: <?php echo htmlspecialchars($sl->project_id); ?>
                                    <a href="<?= URLROOT ?>/Components/Project/index/<?php echo htmlspecialchars($sl->project_id); ?>" class="view-project">View</a>
                                </div>
                            </div>
                            <div class="feedback-content">
                                <?php echo htmlspecialchars($sl->feedback); ?>
                            </div>
                            <div class="solved-info">
                                <?php echo "solved by:";
                                if ($sl->role_id == 1) {
                                    echo "Admin";
                                } elseif ($sl->role_id == 2) {
                                    echo "Supervisor";
                                } elseif ($sl->role_id == 3) {
                                    echo "Site Head";
                                } elseif ($sl->role_id == 4) {
                                    echo "Landowner";
                                } else {
                                    echo "Unknown Role";
                                }
                                ?>
                            </div>
                            <div class="feedback-actions">
                                <form method="post" action="<?= URLROOT ?>/sitehead/Feedback/deleteFeedback" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                                    <button type="submit" name="feedback_id" value="<?= htmlspecialchars($sl->id) ?>" class="button delete-button">Delete</button>
                                </form>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-feedback">No solved feedbacks found!</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function openTab(tabName) {
            // Hide all tab contents
            const tabContents = document.getElementsByClassName('tab-content');
            for (let i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove('active');
            }

            // Deactivate all tab buttons
            const tabButtons = document.getElementsByClassName('tab-btn');
            for (let i = 0; i < tabButtons.length; i++) {
                tabButtons[i].classList.remove('active');
            }

            // Show the selected tab content and activate the button
            document.getElementById(tabName).classList.add('active');
            event.currentTarget.classList.add('active');
        }
    </script>
</body>

</html>