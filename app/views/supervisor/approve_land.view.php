<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin/project.css">

    <title>Green & White Form</title>

</head>

<body>
    <style>
        /* Custom alert style */
        .alert-custom {
            color: white;
            background-color: #f44336;
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>

    <?php $showBigForm = $data['showBigForm'] ?? false; ?>

    <div class="form-container">
        <div class="info">
            Kindly complete all fields below using the specific details gathered during the site visit. The information you provide will be used to initialize the project in our system. Please ensure that all details are accurate and complete.
            Upon verification and submission of this form, the system will initialize the project.
        </div>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="message success-message"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>

        <?php if (!empty($data['message'])): ?>
            <div class="message error-message"><?php echo $data['message']; ?></div>
        <?php endif; ?>

        <h2></h2>

        <!-- Display alert message -->
        <?php if (!empty($alertMessage)): ?>
            <div class="alert-custom">
                <?php echo $alertMessage; ?>
            </div>
        <?php endif; ?>
 
        <!-- Only show small form if no alert message is set -->
        <?php if (empty($alertMessage) && !$showBigForm): ?>
            <form action="<?= URLROOT ?>/Supervisor/Approve_land/" method="POST">
                <div class="lil-form">
                    <div class="form-group">
                        <label for="land_id">Land id</label>
                        <input type="number" id="land_id" name="land_id" >
                    </div>
                    <button type="submit">Submit</button>
                </div>
            </form>
        <?php endif; ?>

        <!-- Only show big form if there is no alert message and the form is set to be shown -->
        <?php if (empty($alertMessage) && $showBigForm): ?>
            <div class="big-form">
                <form action="<?= URLROOT ?>/Supervisor/Approve_land/" method="POST">
                    <div class="form-group">
                        <label for="crop_type">Selected Crop type</label>
                        <div class="note">preferred crop of the landowner: <?php echo htmlspecialchars($landInfo->crop_type); ?></div>
                        <input type="text" id="crop_type" name="crop_type" required>
                    </div>

                    <input type="number" id="land_id" name="land_id" hidden value="<?php echo htmlspecialchars($landInfo->id); ?>">

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
        <?php endif; ?>

        <div class="form-footer">
            
        </div>
    </div>

</body>

</html>
