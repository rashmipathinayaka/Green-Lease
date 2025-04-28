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
                <h4>These are the upcoming visits you have to attend. If you have a problem with the scheduled date, you can re-schedule or approve the visit.</h4>
                <br><br>

                <table class="rvisits-table">
                    <thead>
                        <tr>
                            <th>Visit ID</th>
                            <th>Land Address</th>
                            <th>Scheduled Date From</th>
                            <th>Scheduled Date To</th>
                            <th>Action</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($visitdata)): ?>
                            <?php foreach ($visitdata as $visit): ?>
                                <tr>
                                    <td><?= htmlspecialchars($visit->id) ?></td>
                                    <td><?= htmlspecialchars($visit->address) ?></td>
                                    <td><?= htmlspecialchars($visit->from_date) ?></td>
                                    <td><?= htmlspecialchars($visit->to_date) ?></td>
                                    <td>
                                        <button class="btn btn-reschedule"
                                            onclick="showRescheduleForm('<?= htmlspecialchars($visit->id) ?>', '<?= htmlspecialchars($visit->address) ?>', '<?= htmlspecialchars($visit->from_date) ?>', '<?= htmlspecialchars($visit->to_date) ?>')">
                                            Schedule
                                        </button>
                                    </td>
                                    <td>

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
                    <button type="button" class="close-btn" onclick="hideRescheduleForm()">×</button>
                    <form id="rescheduleVisitForm" method="POST" action="<?php echo URLROOT; ?>/Supervisor/Site_visit/rescheduleVisit">
                        <input type="hidden" name="visit_id" id="formVisitId">
                        <input type="hidden" name="land_id" id="formLandId">
                        <input type="hidden" id="fromDate" name="fromDate">
                        <input type="hidden" id="toDate" name="toDate">

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
            <h4>You will receive emails regarding these field-visits.</h4>
            <h5>Only the upcoming visits from today onwards are shown here.</h5>
            <br><br>

            <div class="container">
                <table class="rvisits-table">
                    <thead>
                        <tr>
                            <th>Visit ID</th>
                            <th>Land Address</th>
                            <th>New Scheduled Date & Time</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($visitdata1)): ?>
                            <?php foreach ($visitdata1 as $visit1): ?>
                                <tr>
                                    <td><?= htmlspecialchars($visit1->id) ?></td>
                                    <td><?= htmlspecialchars($visit1->address) ?></td>
                                    <td><?= htmlspecialchars($visit1->re_date) ?></td>
                                    <td>
                                        <button class="btn btn-bigform"
                                            onclick="showBigForm('<?= htmlspecialchars($visit1->land_id) ?>', '<?= htmlspecialchars($visit1->crop_type) ?>')">
                                            Approve
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-bigform"
                                            onclick="showRejectForm('<?= htmlspecialchars($visit1->id) ?>')">
                                            Reject
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div id="bigFormContainer" class="big-form-container" style="display:none;">
                <button type="button" class="close-btn" onclick="hideBigForm()">×</button>
                <form action="<?= URLROOT ?>/Supervisor/site_visit/initializeproject" method="POST">
                    <div class="form-group">
                        <label for="crop_type">Selected Crop type</label>
                        <div class="note">Preferred crop of the landowner: <?php echo htmlspecialchars($visit1->crop_type); ?></div>
                        <input type="text" id="crop_type" name="crop_type" required>
                    </div>

                    <input type="hidden" id="land_id" name="land_id" value="<?php echo htmlspecialchars($visit1->id); ?>">

                    <div class="form-group">
                        <label for="duration">Duration of the project</label>
                        <input type="number" id="duration" name="duration" required>
                    </div>

                    <div class="form-group">
                        <label for="sitehead">Select Site Head</label>
                        <select id="sitehead" name="sitehead" required>
                            <option value="">-- Select Site Head --</option>
                            <?php foreach ($sitehead as $sh): ?>
                                <option value="<?= htmlspecialchars($sh->id) ?>">
                                    <?= htmlspecialchars($sh->full_name) ?> ---------- <?= htmlspecialchars($sh->status) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="profit">Profit percentage of the project</label>
                        <input type="number" id="profit" name="profit" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Any special notes:</label>
                        <input type="text" id="description" name="description" required>
                    </div>

                    <button type="submit">Submit</button>
                </form>
            </div>

            <div id="rejectForm" class="reject-form-container" style="display:none;">
                <button type="button" class="rclose-btn" onclick="hideRejectForm()">×</button>
                <div class="reject-form-content">
                    <form id="rejectVisitForm" method="POST" action="<?php echo URLROOT; ?>/Supervisor/Site_visit/rejectVisit">
                        <!-- Hidden field for visit ID -->
                        <input type="hidden" name="visit_id" id="rejectVisitId" value="<?php echo htmlspecialchars($visit1->id); ?>">

                        <h3>Reject Site Visit</h3><br>

                        <div class="form-group">
                            <label>Visit ID:</label>
                            <!-- Display the Visit ID dynamically -->
                            <div class="display-field" id="rejectVisitIdDisplay"><?php echo htmlspecialchars($visit1->id); ?></div>
                        </div>

                        <div class="form-group">
                            <label for="reasons">Reason for rejection:</label>
                            <input type="text" name="reasons" id="reasons" required>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-save">Submit</button>
                            <button type="button" class="btn-cancel" onclick="hideRejectForm()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

</body>

<script>
  function showRejectForm(visitId) {
    document.getElementById('rejectVisitId').value = visitId;
    document.getElementById('rejectVisitIdDisplay').innerText = visitId;
    document.getElementById('rejectForm').style.display = 'block';
}

function hideRejectForm() {
    document.getElementById('rejectForm').style.display = 'none';
}
    function showBigForm(landId, cropType) {
        document.getElementById('land_id').value = landId;
        document.getElementById('crop_type').value = cropType;
        document.getElementById('bigFormContainer').style.display = 'block';
    }

    function hideBigForm() {
        document.getElementById('bigFormContainer').style.display = 'none';
    }

    function showRescheduleForm(visitId, address, fromDate, toDate) {
        document.getElementById('formVisitId').value = visitId;
        document.getElementById('displayVisitId').innerText = visitId;
        document.getElementById('displayLandAddress').innerText = address;

        const dateInput = document.getElementById('newDate');
        dateInput.min = fromDate;
        dateInput.max = toDate;

        dateInput.addEventListener('keydown', function(e) {
            e.preventDefault();
        });

        document.getElementById('rescheduleForm').style.display = 'block';
    }

    function hideRescheduleForm() {
        document.getElementById('rescheduleForm').style.display = 'none';
    }
</script>

</html>