<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin/manage-bids.css">
    <script src="<?php echo URLROOT; ?>/assets/JS/admin.js" defer></script>

    <title>Document</title>

</head>

<body>

    <?php
    require ROOT . '/views/admin/sidebar.php';
    require ROOT . '/views/components/topbar.php';
    ?>

<div id="manage-land-section">
        <!-- Tab Navigation -->
         
        <div class="tab-navigation">
            <button class="tab-btn active" data-tab-target="pending-approvals">Pending approval</button>
            <button class="tab-btn" data-tab-target="approved-visit">Approved visits</button>
        </div>


        <!-- Tab Contents -->
        <div id="pending-approvals" class="tab-content active">
            <center>
                <h1>Manage pending lands</h1>

            </center>


         

            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>LandID</th>
                        <th>Address</th>
                        <th>Size</th>
                        <th>Crop type</th>
                        <th>Legal Document</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="supervisor-list">
                    <?php if (!empty($lands)): ?>
                        <?php foreach ($lands as $land): ?>
                            <tr data-id="<?= htmlspecialchars($land->id) ?>">
                                <td><?= htmlspecialchars($land->id) ?></td>
                                <td><?= htmlspecialchars($land->address) ?></td>
                                <td><?= htmlspecialchars($land->size) ?> Sqm</td>
                                <td><?= htmlspecialchars($land->crop_type) ?></td>
                                <td>
                                    <?php if (!empty($land->document)): ?>
                                        <a href="<?php echo URLROOT . '/' . $land->document; ?>" target="_blank">
                                            View Document
                                        </a>
                                    <?php else: ?>
                                        No Attachment
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= URLROOT ?>/Admin/Pending_approval/getland/<?php echo $land->id; ?>">
                                        <button class="red-btn">site visit</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No lands available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div id="approved-visit" class="tab-content">
            <center>
                <h1>Approved Visits</h1>
            </center>
            <!-- Content for Approved Visits tab would go here -->
            <p>Approved visits content will appear here.</p>
        </div>
    </div>



</body>

</html>