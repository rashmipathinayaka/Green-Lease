<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/supervisor.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/supervisor/fertilizer_approval.css">
</head>

<body>

    <?php
    // Check if request data is available
    if (!isset($request) || !isset($fertilizer)) {
        header('Location: ' . URLROOT . '/Supervisor/Manage_fertilizer');
        exit();
    }
    ?>

    <div class="section">
        <div class="approval-container">
            <h1>Process Fertilizer Request</h1>

            <div class="request-details">
                <h2>Request Details</h2>
                <p><strong>Sitehead:</strong> <?= htmlspecialchars($request->user_name) ?></p>
                <p><strong>Crop Type:</strong> <?= htmlspecialchars($request->crop_type) ?></p>
                <p><strong>Fertilizer:</strong> <?= htmlspecialchars($request->fertilizer_type) ?></p>
                <p><strong>Amount Requested:</strong> <?= htmlspecialchars($request->amount) ?> kg</p>
                <p><strong>Preferred Date:</strong> <?= htmlspecialchars($request->preferred_date) ?></p>
                <p><strong>Remarks:</strong> <?= htmlspecialchars($request->remarks) ?></p>
            </div>

            <div class="stock-details">
                <h2>Stock Information</h2>
                <p><strong>Current Stock:</strong> <?= htmlspecialchars($fertilizer->amount) ?> kg</p>
                <p><strong>After Deduction:</strong> <?= ($fertilizer->amount - $request->amount) ?> kg</p>
            </div>

            <?php if ($fertilizer->amount >= $request->amount): ?>
                <form method="POST" action="<?= URLROOT ?>/Supervisor/Manage_fertilizer/processApproval/<?= $request->id ?>">
                    <div class="form-group">
                        <label for="actual_amount">Amount to Approve (kg)</label>
                        <input type="number" name="actual_amount" id="actual_amount"
                            value="<?= $request->amount ?>" min="1" max="<?= $request->amount ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="planned_date">Actual Delivery Date</label>
                        <input type="date" name="planned_date" id="planned_date"
                            value="<?= $request->preferred_date ?>" min="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="notes">Additional Notes</label>
                        <textarea name="notes" id="notes" rows="3"></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="green-btn">Confirm Approval</button>
                        <a href="<?= URLROOT ?>/Supervisor/Manage_fertilizer" class="red-btn">Cancel</a>
                    </div>
                </form>
            <?php else: ?>
                <div class="insufficient-stock">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h3>Insufficient Stock</h3>
                    <p>Cannot process this request. Current stock (<?= $fertilizer->amount ?> kg) is less than requested amount (<?= $request->amount ?> kg).</p>
                    <a href="<?= URLROOT ?>/Supervisor/Manage_fertilizer" class="blue-btn">Back to Requests</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>