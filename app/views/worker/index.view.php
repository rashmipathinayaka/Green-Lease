<!DOCTYPE html>
<html lang="<?= getCurrentLanguage() ?>">
<head>
    <meta charset="UTF-8">
    <title><?= translate('Worker Dashboard') ?></title>
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/worker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .confirmation-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .confirmation-modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .confirmation-modal-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .confirmation-modal-body {
            margin-bottom: 20px;
        }

        .confirmation-modal-footer {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            text-align: right;
        }

        .confirmation-modal-footer button {
            margin-left: 10px;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .cancel-btn {
            background-color: #6c757d;
            color: white;
            border: none;
        }

        .confirm-btn {
            background-color: #2e7d32;
            color: white;
            border: none;
        }

        .alert {
            padding: 10px 15px;
            margin: 10px 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            display: none;
            position: relative;
            z-index: 1000;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .no-events-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }

        .no-events-icon {
            font-size: 48px;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .no-events-content h3 {
            color: #2e7d32;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .no-events-content p {
            color: #6c757d;
            font-size: 16px;
            max-width: 500px;
            line-height: 1.5;
        }
    </style>
</head>
<body style="margin-top: 100px; margin-left: 20px; margin-right: 20px;">

<?php
require ROOT . '/views/worker/sidebar.php';
require ROOT . '/views/components/topbar.php';

$lang = $_SESSION['lang'] ?? 'en'; ?>

    <div class="welcome-container">
        <div class="welcome-header">
            <h1><?= translate('Hello') ?>, <span class="username"><?= htmlspecialchars($sname) ?></span> ! 👋</h1>
            <p class="welcome-message"><?= translate('Welcome back to your dashboard') ?></p>
        </div>
    </div>

    <div id="alertContainer" style="margin: 20px;"></div>

    <div class="worker-events-section">
        <div class="worker-events-header" style="margin-top: 70px;">
            <h2><?= translate('Available Jobs') ?></h2>
        </div>

        <div class="worker-events-list">
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): ?>
                    <div class="worker-event-card">
                        <div class="worker-event-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="worker-event-details">
                            <div class="worker-event-header">
                                <h3><?= htmlspecialchars($event->event_name) ?></h3>
                            </div>
                            <div class="worker-event-info">
                                <span><i class="fas fa-clock"></i> <?= $event->date?></span>
                                <span><i class="fas fa-map-pin"></i> <?= translate('Project ID') ?>: <?= $event->project_id ?></span>
                                <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($event->land_address ?? translate('Location not specified')) ?></span>
                            </div>
                        </div>
                        <div class="worker-event-actions">
                            <button class="green-btn" onclick="confirmApply(<?= $event->id ?>)"><?= translate('Apply') ?></button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-events-container">
                    <div class="no-events-icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <div class="no-events-content">
                        <h3><?= translate('No Available Jobs') ?></h3>
                        <p><?= translate('There are no jobs available at the moment. Please check back later for new opportunities.') ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="confirmationModal" class="confirmation-modal">
        <div class="confirmation-modal-content">
            <div class="confirmation-modal-header">
                <h3><?= translate('Confirm Application') ?></h3>
            </div>
            <div class="confirmation-modal-body">
                <p><?= translate('Are you sure you want to apply for this event? Once applied, you will be notified when your application is reviewed.') ?></p>
            </div>
            <div class="confirmation-modal-footer">
                <button type="button" class="cancel-btn" onclick="closeModal()"><?= translate('Cancel') ?></button>
                <button type="button" class="confirm-btn" onclick="submitApplication()"><?= translate('Confirm Apply') ?></button>
            </div>
        </div>
    </div>

    <script>
        let currentEventId = null;

        function confirmApply(eventId) {
            currentEventId = eventId;
            document.getElementById('confirmationModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('confirmationModal').style.display = 'none';
            currentEventId = null;
        }

        function submitApplication() {
            if (!currentEventId) return;

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= URLROOT ?>/Worker/Index';

            const eventIdInput = document.createElement('input');
            eventIdInput.type = 'hidden';
            eventIdInput.name = 'event_id';
            eventIdInput.value = currentEventId;

            form.appendChild(eventIdInput);
            document.body.appendChild(form);
            form.submit();
        }

        function showAlert(message, type) {
            const alertContainer = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            alert.style.display = 'block';
            
            alertContainer.innerHTML = '';
            alertContainer.appendChild(alert);

            setTimeout(() => {
                alert.style.display = 'none';
            }, 5000);
        }

        window.onclick = function(event) {
            const modal = document.getElementById('confirmationModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        <?php if(isset($_SESSION['message'])): ?>
            showAlert('<?= $_SESSION['message'] ?>', '<?= $_SESSION['message_type'] ?>');
            <?php 
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>
    </script>

</body>
</html>
