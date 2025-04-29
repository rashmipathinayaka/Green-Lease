<!DOCTYPE html>
<html lang="<?= getCurrentLanguage() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/buyer.css">
    <title><?= translate('File a Complaint') ?></title>
</head>
<body style="margin-top: 100px; margin-left: 20px; margin-right: 20px;">
<?php
require ROOT . '/views/worker/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>
<div id="file-a-complaint-section" class="section">
    <div class="complaint-section">
        <div class="form-container">
            <h1 class="complaint-topic"><?= translate('File a Complaint') ?></h1>
            
            <?php if(isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form class="form" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="complaint-type"><?= translate('Complaint Type') ?></label>
                    <select id="complaint-type" name="complaint-type" required>
                        <option value="">-- <?= translate('Select Type') ?> --</option>
                        <option value="Workplace Safety Issues"><?= translate('Workplace Safety Issues') ?></option>
                        <option value="Salary Payment Delays"><?= translate('Salary Payment Delays') ?></option>
                        <option value="Unfair Treatment by Management"><?= translate('Unfair Treatment by Management') ?></option>
                        <option value="Faulty Equipment or Tools"><?= translate('Faulty Equipment or Tools') ?></option>
                        <option value="Excessive Working Hours"><?= translate('Excessive Working Hours') ?></option>
                        <option value="Denied or Delayed Leave Requests"><?= translate('Denied or Delayed Leave Requests') ?></option>
                        <option value="Inadequate Training Provided"><?= translate('Inadequate Training Provided') ?></option>
                        <option value="Excessive Workload"><?= translate('Excessive Workload') ?></option>
                        <option value="Poor Communication from Supervisors"><?= translate('Poor Communication from Supervisors') ?></option>
                        <option value="Other"><?= translate('Other') ?></option>
                    </select>
                    <label for="description"><?= translate('Complaint Description') ?></label>
                    <textarea id="description" name="description" required
                        placeholder="<?= translate('Please provide detailed information about your complaint...') ?>"></textarea>
                    <label for="attachment"><?= translate('Supporting Documents (if any)') ?></label>
                    <input type="file" id="attachment" name="attachment">
                    <p class="attachment-note"><?= translate('Accepted file formats: PDF, JPG, PNG (Max size: 5MB)') ?></p>
                                   
                    <button class="form-submit-btn" type="submit">
                        <i class="fas fa-paper-plane"></i>&nbsp; <?= translate('Submit Complaint') ?>
                    </button>
                </div>  
            </form>
        </div>
    </div>
</div>
</body>
</html>