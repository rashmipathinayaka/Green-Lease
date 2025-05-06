<!DOCTYPE html>
<html lang="<?= getCurrentLanguage() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= translate('Work Records') ?></title>
    <link rel="stylesheet" href="<?= URLROOT; ?>/assets/css/worker.css">
    <style>
        .tab-navigation {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .tab-btn {
            padding: 10px 20px;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 16px;
            color: #666;
            transition: all 0.3s ease;
        }

        .tab-btn.active {
            color: #2e7d32;
            border-bottom: 2px solid #2e7d32;
            margin-bottom: -12px;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .filter-form {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-form select,
        .filter-form input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .filter-form button {
            padding: 8px 16px;
            background-color: #2e7d32;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .filter-form button:hover {
            background-color: #1b5e20;
        }
    </style>
</head>
<body style="margin-top: 100px; margin-left: 20px; margin-right: 20px;">
<?php
require ROOT . '/views/worker/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>

<div id="work-records-section" class="section">
    <center>
        <h1><?= translate('Work Records') ?></h1>
    </center>

    <div class="tab-navigation">
        <button class="tab-btn active" onclick="switchTabs(this, 'pending-work')"><?= translate('Pending') ?></button>
        <button class="tab-btn" onclick="switchTabs(this, 'completed-work')"><?= translate('Completed') ?></button>
    </div>

	<form method="GET" action="" class="filter-form">
        <label for="date_from" style="margin-right: 2px; color: #333; font-size: 14px;"><?= translate('From') ?></label>
        <input type="date" name="date_from" id="date_from" value="<?= isset($_GET['date_from']) ? htmlspecialchars($_GET['date_from']) : '' ?>" placeholder="<?= translate('From Date') ?>">
        <label for="date_to" style="margin-left: 8px; margin-right: 2px; color: #333; font-size: 14px;"><?= translate('To') ?></label>
        <input type="date" name="date_to" id="date_to" value="<?= isset($_GET['date_to']) ? htmlspecialchars($_GET['date_to']) : '' ?>" placeholder="<?= translate('To Date') ?>">
        <button type="submit"><?= translate('Apply Filters') ?></button>
    </form>

    <div id="pending-work" class="tab-content active">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th><?= translate('Land Location') ?></th>
                    <th><?= translate('Event Name') ?></th>
                    <th><?= translate('Date') ?></th>
                    <th><?= translate('Payment (LKR)') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pending_work)) : ?>
                    <?php foreach ($pending_work as $work): ?>
                        <tr>
                            <td><?= htmlspecialchars($work->land_location) ?></td>
                            <td><?= htmlspecialchars($work->event_name) ?></td>
                            <td><?= htmlspecialchars($work->date) ?></td>
                            <td><?= htmlspecialchars($work->payment_per_worker) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" style="text-align: center;"><?= translate('No pending work found.') ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div id="completed-work" class="tab-content">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th><?= translate('Land Location') ?></th>
                    <th><?= translate('Event Name') ?></th>
                    <th><?= translate('Date') ?></th>
                    <th><?= translate('Payment (LKR)') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($completed_work)) : ?>
                    <?php foreach ($completed_work as $work): ?>
                        <tr>
                            <td><?= htmlspecialchars($work->land_location) ?></td>
                            <td><?= htmlspecialchars($work->event_name) ?></td>
                            <td><?= htmlspecialchars($work->date) ?></td>
                            <td><?= htmlspecialchars($work->payment_per_worker) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" style="text-align: center;"><?= translate('No completed work found.') ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function switchTabs(btn, tabId) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
}
</script>
</body>
</html>