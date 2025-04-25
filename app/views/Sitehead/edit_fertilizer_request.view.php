<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Fertilizer Request</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/sitehead.css">
</head>

<body>
    <?php require ROOT . '/views/sitehead/sidebar.php'; ?>
    <?php require ROOT . '/views/components/topbar.php'; ?>

    <div class="section">
        <div class="complaint-section">
            <div class="form-container">
                <h1 class="complaint-topic">Edit Fertilizer Request</h1>

                <form class="form" method="POST" action="<?= URLROOT ?>/Sitehead/Update_request/updateRequest/<?= $request->id ?>">
                    <div class="form-group">
                        <label for="fertilizer_id">Fertilizer Type</label>
                        <select name="fertilizer_id" required>
                            <?php foreach ($fertilizers as $fertilizer): ?>
                                <option value="<?= $fertilizer->id ?>" <?= $fertilizer->id == $request->fertilizer_id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($fertilizer->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="project_id">Project</label>
                        <select name="project_id" required>
                            <?php foreach ($projects as $project): ?>
                                <option value="<?= $project->id ?>" <?= $project->id == $request->project_id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($project->crop_type) ?> (Land ID: <?= $project->land_id ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount (kg)</label>
                        <input type="number" name="amount" value="<?= htmlspecialchars($request->amount) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="preferred_date">Preferred Delivery Date</label>
                        <input type="date" name="preferred_date" value="<?= htmlspecialchars($request->preferred_date) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="remarks">Remarks (optional)</label>
                        <textarea name="remarks"><?= htmlspecialchars($request->remarks) ?></textarea>
                    </div>

                    <button type="submit" class="form-submit-btn">Update Request</button>
                </form>

                <?php if (!empty($errors)): ?>
                    <div class="error-list">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>