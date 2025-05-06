<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin/manage-bids.css">
    <script src="<?php echo URLROOT; ?>/assets/JS/admin.js" defer></script>

    <title>Pending Approvals</title>

    <style>
        .note-container {
            margin: 20px 0;
            padding: 0 20px;
        }

        .note {
            background-color: #e8f5e9;
            border-left: 4px solid #4CAF50;
            padding: 15px 20px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 12px;
            max-width: 800px;
            margin: 0 auto;
        }

        .note i {
            color: #4CAF50;
            font-size: 22px;
            flex-shrink: 0;
        }

        .note p {
            margin: 0;
            color: #2e7d32;
            font-size: 16px;
            line-height: 1.5;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .note-container {
                padding: 0 15px;
            }

            .note {
                padding: 12px 15px;
            }
        }
    </style>

</head>

<body>

    <?php
    require ROOT . '/views/admin/sidebar.php';
    require ROOT . '/views/components/topbar.php';
    ?>

    <div id="manage-land-section">
        <!-- Tab Navigation -->

        <div class="tab-navigation" style="margin-left: 20px; margin-right: 20px; margin-top: 20px;">
            <button class="tab-btn active" data-tab-target="pending-approvals">Pending Approval</button>
            <button class="tab-btn" data-tab-target="approved-visit">Approved Visits</button>
            <button class="tab-btn" data-tab-target="initialize-project">Initialize Projects</button>
        </div>


        <!-- Tab Contents -->
        <div id="pending-approvals" class="tab-content active">
            <center>
                <h1>Manage Pending Lands</h1>

            </center>

            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>LandID</th>
                        <th>Address</th>
                        <th>Size</th>
                        <th>Crop type</th>
                        <th>Legal Document</th>
                        <th>Actions</th>
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
                                        <a href="<?php echo URLROOT . '/' . $land->document; ?>" target="_blank" class="document-link">
                                        <i class="fas fa-file-alt"></i>  View Document
                                        </a>
                                    <?php else: ?>
                                        <span class="no-document">No Attachment</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= URLROOT ?>/Admin/Pending_approval/opensitevisit/<?php echo $land->id; ?>">
                                        <button class="green-btn">site visit</button>
                                    </a>
                                    <a href="<?= URLROOT ?>/Admin/Pending_approval/rejectland/<?php echo $land->id; ?>">
                                        <button class="red-btn">Reject land</button>
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

            <div class="container">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Visit ID</th>
                            <th>Land ID</th>
                            <!-- <th>previous date</th> -->
                            <th>New Scheduled Date & Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($visitdata1)): ?>
                            <?php foreach ($visitdata1 as $visit1): ?>
                                <tr data-land-id="<?= htmlspecialchars($visit1->id) ?>">
                                    <td><?= htmlspecialchars($visit1->id) ?></td>
                                    <td><?= htmlspecialchars($visit1->address) ?></td>
                                    <!-- <td><?= htmlspecialchars($visit1->date) ?></td> -->
                                    <td><?= htmlspecialchars($visit1->re_date) ?></td>
                                    <td> <a href="<?= URLROOT ?>/Admin/Pending_approval/getland/<?php echo $visit1->id; ?>">
                                            <button class="green-btn">send email</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>



        <div id="initialize-project" class="tab-content">
            <center>
                <h1>Lands Approved by the Site Visit</h1>
            </center>
            <div class="note-container">
                <div class="note">
                    <i class="fas fa-info-circle"></i>
                    <p>A project will be initialized when the following projects are approved.</p>
                </div>
            </div>
            <div class="container">

                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <!-- <th>Project ID</th> -->
                            <th>Visit ID</th>
                            <th>Land ID</th>
                            <th>Zone</th>
                            <th>Preffered crop</th>
                            <th>Selected crop</th>
                            <th>Duration</th>
                            <th>Description</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($project)): ?>
                            <?php foreach ($project as $pro): ?>
                                <tr pro-id="<?= htmlspecialchars($pro->id) ?>">
                                    <!-- <td><?= htmlspecialchars($pro->id) ?></td> -->
                                    <td><?= htmlspecialchars($pro->visit_id) ?></td>
                                    <td><?= htmlspecialchars($pro->land_id) ?></td>
                                    <td><?= htmlspecialchars($pro->zone_name) ?></td>
                                    <td><?= htmlspecialchars($pro->crop_type) ?></td>
                                    <td><?= htmlspecialchars($pro->selected_crop) ?></td>
                                    <td><?= htmlspecialchars($pro->duration) ?></td>
                                    <td><?= htmlspecialchars($pro->description) ?></td>


                                    <td> <a href="<?= URLROOT ?>/Admin/Pending_approval/approveproject/<?php echo $pro->id; ?>">
                                            <button class="green-btn">Approve project</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>



        </div>

    </div>

    <style>
        .document-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            background-color: #f0f0f0;
            border-radius: 4px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .document-link:hover {
            background-color: #e0e0e0;
            text-decoration: none;
        }

        .document-link i {
            color: #666;
        }

        .no-document {
            color: #999;
            font-style: italic;
        }
    </style>


</body>



</html>