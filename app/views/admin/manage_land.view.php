<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin/manage-bids.css">

    <title>Document</title>
</head>

<body>

    <?php

    require ROOT . '/views/admin/sidebar.php';
    require ROOT . '/views/components/topbar.php';

    ?>


    <div id="manage-land-section" class="section" ">
                <center>
                    <h1>Manage lands</h1>
                    <h2>These are all the lands registered in the system. <br>
                </h2>
                </center>

                <form method=" GET" action="" class="filter-form" style="margin-bottom: 20px; text-align: center;">
        <label for="crop_type">Crop Type:</label>
        <input type="text" name="crop_type" id="crop_type" value="<?= isset($_GET['crop_type']) ? htmlspecialchars($_GET['crop_type']) : '' ?>">

        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="">All</option>
            <option value="0" <?= (isset($_GET['status']) && $_GET['status'] === '0') ? 'selected' : '' ?>>Pending</option>
            <option value="1" <?= (isset($_GET['status']) && $_GET['status'] === '1') ? 'selected' : '' ?>>Approved</option>
        </select>


        <label for="zone_id">Zone:</label>
        <select name="zone_id" id="zone_id">
            <option value="">All</option>
            <?php foreach ($zones as $zone): ?>
                <option value="<?= $zone->id ?>" <?= (isset($_GET['zone_id']) && $_GET['zone_id'] == $zone->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($zone->zone_name) ?>
                </option>
            <?php endforeach; ?>
        </select>


        <button type="submit">Filter</button>
        </form>







        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>LandID</th>
                    <th>Address</th>
                    <th>Size</th>
                    <th>Crop type</th>
                    <th>Zone</th>
                    <th>Legal Document</th>
                    <th>Status</th>
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
                            <td><?= htmlspecialchars($land->zone_name) ?></td>
                            <td>
                                <?php if (!empty($land->document)): ?>
                                    <a href="<?php echo URLROOT . '/' .  $land->document; ?>" target="_blank">
                                        View Document
                                    </a>

                                <?php else: ?>
                                    No Attachment
                                <?php endif; ?>
                            </td>

                            <td>
                                <?= $land->status === 0 ? "Pending" : "Approved" ?>
                            </td>
                            <td>
                                <?php if ($land->status === 0): ?>
                                    <!-- <button class="red-btn" onclick="window.location.href='<?php echo URLROOT; ?>/admin/Manage_land/updateland/<?php echo $land->id; ?>';">Approve</button> -->
                                <?php else: ?>
                                    <button class="green-btn" onclick="window.location.href='<?php echo URLROOT; ?>/components/project/index/<?php echo $land->project_id; ?>';">View project</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No lands available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>