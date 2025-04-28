<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/sitehead.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/sitehead/project_completion.css">
    <title>Project Completion Form</title>
</head>

<body style="margin-top: 100px; margin-left: 20px; margin-right: 20px;">
    <?php
    require ROOT . '/views/sitehead/sidebar.php';
    require ROOT . '/views/components/topbar.php';
    ?>
    <div class="complaint-section">
        <div class="form-container">
            <h1 class="complaint-topic">Project Completion Form</h1>

            <div class="form-header">
                <?php if ($proinfo): ?>
                    <div class="project-id">
                        Project ID: <span id="project-id-display"><?= $proinfo ? htmlspecialchars($proinfo->id) : 'N/A' ?></span>
                    </div>
                <?php else: ?>
                    <p>No ongoing project found for this user.</p>
                <?php endif; ?> 
                <div class="project-status">Status: <span style="color: #2e7d32; font-weight: bold;">
                    <?php echo $proinfo ? htmlspecialchars($proinfo->status) : 'N/A'; ?>
                </span></div>
            </div>

            <form id="project-completion-form" method="post" action="<?php echo URLROOT; ?>/sitehead/project_completion/index">
                <input type="hidden" name="project_id" id="project-id" value="<?php echo $proinfo ? htmlspecialchars($proinfo->id) : ''; ?>">

                <div class="form-group">
                    <label for="profit-gained">Profit Gained by The Excess Amount of Harvest <span class="required"></span></label>
                    <div class="input-group">
                        <div class="input-group-append">Rs.</div>
                        <input type="number" id="profit-gained" name="profit_gained" required min="0" step="0.01">
                    </div>
                    <div class="help-text">Enter the monetary value gained from selling excess harvest</div>
                </div>

                <div class="form-group">
                    <label for="special-notes">Any Special Notes</label>
                    <textarea id="special-notes" name="special_notes" placeholder="Add any additional information about the harvest, challenges faced, or recommendations for future projects..."></textarea>
                </div>

                <div class="form-group">
                    <div class="checkbox-container">
                        <input type="checkbox" id="mark-complete" name="mark_complete" value="1" required>
                        <label for="mark-complete">Mark this project as complete?</label>
                    </div>
                    <div class="help-text">Check this box to finalize the project and update its status to "Completed"</div>
                </div>

                <div class="form-group">
                    <button type="submit" class="form-submit-btn">Submit & Complete Project</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Any additional client-side functionality
        });
    </script>
</body>
</html>