<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin.css">

    <title>Document</title>
</head>
<body>

<?php

require ROOT . '/views/admin/sidebar.php';
require ROOT . '/views/components/navbar.php';

?>

     
     <div id="manage-land-section" class="section" ">
                <center>
                    <h1>Manage lands</h1>
                    <h2>These are all the lands registered in the system. <br>
                </h2>
                </center>
                <table class="dashboard-table">
        <thead>
            <tr>
                <th>LandID</th>
                <th>Address</th>
                <th>Size</th>
                <th>Crop type</th>
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
                        <td><?= htmlspecialchars($land->crop) ?></td>
                        <td>
                    <?= $land->status === 0 ? "Pending" : "Approved" ?>
                </td>                           
                        <td>
                            <?php if ($land->status === 0): ?>
                                <button class="red-btn"  onclick="window.location.href='<?php echo URLROOT; ?>/admin/Manage_land/updateland/<?php echo $land->id;?>';">Approve</button>
                            <?php else: ?>
                                <button class="green-btn">View</button>
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