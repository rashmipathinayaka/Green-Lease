<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduled Site Visits</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/supervisor/sitevisit.css">
    <script src="<?php echo URLROOT; ?>/assets/js/sitevisit.js" defer></script>
</head>

<body>

<?php
require ROOT . '/views/supervisor/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>




<div id="full-section">
<div class="tab-navigation">
            <button class="tab-btn active" data-tab-target="pending-approvals">Pending approval</button>
            <button class="tab-btn" data-tab-target="approved-visit">Approved visits</button>
        </div>

<div id="pending-approvals" class="tab-content active">

    <div class="container">

        <h1>Scheduled Site Visits</h1>
        <h4>these are the upcomming visits you have to visit. if you have a problem with the scheduled date you can 
            re-schedule or approve the visit.</h4>
            <br><br>

        <table class="rvisits-table">
            <thead>
                <tr>
                    <th>Visit ID</th>
                    <th>Land ID</th>
                    <th>Scheduled Date from</th>
                    <th>Scheduled Date to</th>

                    <th>Action</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($visitdata)): ?>
                    <?php foreach ($visitdata as $visit): ?>
                        <tr data-land-id="<?= htmlspecialchars($visit->id) ?>">
                            <td><?= htmlspecialchars($visit->id) ?></td>
                            <td><?= htmlspecialchars($visit->address) ?></td>
                            <td><?= htmlspecialchars($visit->from_date) ?></td>
                            <td><?= htmlspecialchars($visit->to_date) ?></td>

                            <td>
                            
                                <button class="btn btn-reschedule"
                                    onclick="showRescheduleForm('<?= htmlspecialchars($visit->id) ?>', '<?= htmlspecialchars($visit->address) ?>')">
                                    Schedule
                                </button>

                            </td>
                            <td>
                                <a href="<?= URLROOT ?>/Supervisor/Site_visit/directapprove/<?php echo $visit->id; ?>">
                                    <button class="red-btn">Approve visit</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Reschedule Form (initially hidden) -->
    <div id="rescheduleForm" class="reschedule-form-container" style="display:none;">
        <div class="reschedule-form-content">
            <form id="rescheduleVisitForm" method="POST" action="<?php echo URLROOT; ?>/Supervisor/Site_visit/rescheduleVisit">
                <input type="hidden" name="visit_id" id="formVisitId">
                <input type="hidden" name="land_id" id="formLandId">

                <h3>Reschedule Site Visit</h3><br>
                <div class="form-group">
                    <label>Visit ID:</label>
                    <div class="display-field" id="displayVisitId"></div>
                </div>

                <div class="form-group">
                    <label>Land Address:</label>
                    <div class="display-field" id="displayLandAddress"></div>

                </div>
                <br>
                <div class="form-group">
                    <label for="newDate">Date:</label>
                    <input type="date" name="new_date" id="newDate" required>
                </div>

                <div class="form-group">
                    <label for="newTime">Time:</label>
                    <input type="time" name="new_time" id="newTime" min="09:00" max="17:00" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-save">Save Changes</button>
                    <button type="button" class="btn btn-cancel" onclick="hideRescheduleForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>




<div id="approved-visit" class="tab-content">




<h4>you will recieve emails regarding these field-visits</h4>
<h5>only the upcoming visits from today onwards are shown here</h5>
<br><br>
<div class="container">
   <table class="rvisits-table">
            <thead>
                <tr>
                    <th>Visit ID</th>
                    <th>Land ID</th>
                    <th>previous date</th>
                    <th>New Scheduled Date & Time</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($visitdata1)): ?>
                    <?php foreach ($visitdata1 as $visit1): ?>
                        <tr data-land-id="<?= htmlspecialchars($visit1->id) ?>">
                            <td><?= htmlspecialchars($visit1->id) ?></td>
                            <td><?= htmlspecialchars($visit1->address) ?></td>
                            <td><?= htmlspecialchars($visit1->date)?></td>
                            <td><?= htmlspecialchars($visit1->re_date) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
</div></div>
</div>
</body>

</html>