<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin/manage-bids.css">

    <title>Manage Lands</title>
</head>

<body>

    <?php

    require ROOT . '/views/admin/sidebar.php';
    require ROOT . '/views/components/topbar.php';

    ?>


    <div id="manage-land-section" class="section">
        <div class="section-header">
            <h1>Manage Projects</h1>
        </div>

        <form method="GET" action="" class="filter-form">
            <div class="filter-container">
                <div class="filter-group">
                    <label for="crop_type">Crop Type:</label>
                    <input type="text" name="crop_type" id="crop_type" value="<?= isset($_GET['crop_type']) ? htmlspecialchars($_GET['crop_type']) : '' ?>" placeholder="Enter crop type">
                </div>

                <div class="filter-group">
                    <label for="status">Status:</label>
                    <select name="status" id="status">
                        <option value="">All Status</option>
                        <option value="1" <?= (isset($_GET['status']) && $_GET['status'] === '1') ? 'selected' : '' ?>>Pending</option>
                        <option value="2" <?= (isset($_GET['status']) && $_GET['status'] === '2') ? 'selected' : '' ?>>Ongoing</option>
                        <option value="3" <?= (isset($_GET['status']) && $_GET['status'] === '3') ? 'selected' : '' ?>>Completed</option>
                        <option value="4" <?= (isset($_GET['status']) && $_GET['status'] === '4') ? 'selected' : '' ?>>Rejected</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="zone_id">Zone:</label>
                    <select name="zone_id" id="zone_id">
                        <option value="">All Zones</option>
                        <?php foreach ($zones as $zone): ?>
                            <option value="<?= $zone->id ?>" <?= (isset($_GET['zone_id']) && $_GET['zone_id'] == $zone->id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($zone->zone_name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <button type="submit" class="filter-btn">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                </div>
            </div>
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
                        <tr data-id="<?= htmlspecialchars($land->id ?? '') ?>">
                            <td><?= htmlspecialchars($land->id ?? '') ?></td>
                            <td><?= htmlspecialchars($land->address ?? '') ?></td>
                            <td><?= htmlspecialchars($land->size ?? '') ?> Sqm</td>
                            <td><?= htmlspecialchars($land->crop_type ?? '') ?></td>
                            <td><?= htmlspecialchars($land->zone_name ?? '') ?></td>
                            <td>
                                <?php if (!empty($land->document)): ?>
                                    <a href="<?php echo URLROOT . '/' .  $land->document; ?>" target="_blank" class="document-link">
                                        <i class="fas fa-file-alt"></i> View Document
                                    </a>
                                <?php else: ?>
                                    <span class="no-document">No Attachment</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php
                                if ($land->status == "Pending") {
                                    echo "Pending";
                                } elseif ($land->status == "Ongoing") {
                                    echo "Ongoing";
                                } elseif ($land->status == "Completed") {
                                    echo "Completed";
                                } elseif ($land->status == "Rejected") {
                                    echo "Rejected";
                                } else {
                                    echo "Unknown";
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($land->status == "Ongoing" || $land->status == "Completed"): ?>
                                    <button class="green-btn" onclick="window.location.href='<?php echo URLROOT; ?>/project/index/<?php echo $land->project_id; ?>';">View project</button>
                                <?php else: ?>
                                    <!-- put another button or leave it empty -->
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

        .section {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .section-header h1 {
            color: #333;
            font-size: 24px;
            margin: 0;
        }

        .filter-form {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .filter-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: flex-end;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
            margin-bottom: 0;
        }

        .filter-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        .filter-group input,
        .filter-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .filter-group input:focus,
        .filter-group select:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.1);
        }

        .filter-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
            height: 40px;
        }

        .filter-btn:hover {
            background-color: #45a049;
        }

        .filter-btn i {
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .section {
                padding: 15px;
            }

            .filter-form {
                padding: 20px;
            }

            .filter-container {
                flex-direction: column;
                gap: 15px;
            }

            .filter-group {
                width: 100%;
            }
        }
    </style>
</body>

</html>