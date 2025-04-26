<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(URLROOT); ?>/assets/css/feedback.css">

    <title>Feedback Management System</title>

</head>
<style>
.modal {
    display: none; 
    position: fixed; 
    z-index: 999; 
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0,0,0,0.4); 
}

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border-radius: 10px;
    width: 300px;
    box-shadow: 0px 0px 10px 2px #aaa;
    position: relative;
}
.remark {
    margin-top: 10px;
    padding: 10px 15px;
    background-color: #f0f9f0; /* light greenish background */
    border-left: 4px solid #4CAF50; /* darker green border */
    border-radius: 6px;
    font-style: normal;
}

.remark-info {
    font-style: italic;
    color: #333; /* dark text */
    font-size: 15px;
}


.close {
    color: #aaa;
    float: right;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover {
    color: black;
}

#remarkInput {
    width: 100%;
    height: 80px;
    margin-top: 10px;
    padding: 5px;
}
</style>

<body>

    <?php

    require ROOT . '/views/admin/sidebar.php';
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
                            <form method="post" action="<?php echo htmlspecialchars(URLROOT); ?>/admin/Feedback/markSolved" class="solve-form">
    <input type="hidden" name="feedback_id" value="<?php echo htmlspecialchars($us->id); ?>">
    <input type="hidden" name="remark" value="">
    <button type="button" class="button solve-button" onclick="openRemarkBox(this)">Mark as Solved</button>
</form>


                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-feedback">No unsolved feedbacks found!</div>
                <?php endif; ?>
            </div>
        </div>




<!-- Remark Popup Modal -->
<div id="remarkModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeRemarkBox()">&times;</span>
        <h3>Enter a Remark</h3>
        <textarea id="remarkInput" placeholder="Type your remark here..."></textarea>
        <br>
        <button onclick="submitRemark()">Submit Remark</button>
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

                        <div class="remark">
                            <span class="remark-info">Remark: <?php echo htmlspecialchars($sl->remark); ?></span>
                        </div>

                            <div class="feedback-actions">
                                <form method="post" action="<?= URLROOT ?>/admin/Feedback/deleteFeedback" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
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




let currentForm = null;

function openRemarkBox(button) {
    currentForm = button.closest('form'); // find the form related to the button
    document.getElementById('remarkModal').style.display = 'block'; // open modal
}

function closeRemarkBox() {
    document.getElementById('remarkModal').style.display = 'none'; // close modal
    document.getElementById('remarkInput').value = ''; // clear textarea
}

function submitRemark() {
    const remark = document.getElementById('remarkInput').value.trim();

    if (remark === '') {
        alert('Please enter a remark!');
        return;
    }

    if (currentForm) {
        currentForm.querySelector('input[name="remark"]').value = remark;
        currentForm.submit();
    }
}
</script>

  
</body>

</html>