<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Worker Dashboard</title>
    <link rel="stylesheet" href="<?= URLROOT ?>/assets/css/worker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Modal Styles */
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

        /* Alert Styles */
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
    </style>
</head>
<body style="margin-top: 100px; margin-left: 20px; margin-right: 20px;">

<?php
require ROOT . '/views/worker/sidebar.php';
require ROOT . '/views/components/topbar.php';
?>

    <div class="welcome-container">
        <div class="welcome-header">
            <h1>Hello, <span class="username"><?= htmlspecialchars($sname) ?></span> ! 👋</h1>
            <p class="welcome-message">Welcome back to your dashboard</p>
        </div>
    </div>

    <!-- Alert container -->
    <div id="alertContainer" style="margin: 20px;"></div>

    <div class="worker-events-section">
        <div class="worker-events-header" style="margin-top: 70px;">
            <h2>Available Jobs</h2>
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
                                <span><i class="fas fa-map-pin"></i> Project ID: <?= $event->project_id ?></span>
                                <span><i class="fas fa-user"></i> Assigned Supervisor</span>
                            </div>
                        </div>
                        <div class="worker-event-actions">
                            <button class="green-btn" onclick="confirmApply(<?= $event->id ?>)">Apply</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-events-message">No available events right now.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="confirmation-modal">
        <div class="confirmation-modal-content">
            <div class="confirmation-modal-header">
                <h3>Confirm Application</h3>
            </div>
            <div class="confirmation-modal-body">
                <p>Are you sure you want to apply for this event? Once applied, you will be notified when your application is reviewed.</p>
            </div>
            <div class="confirmation-modal-footer">
                <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                <button type="button" class="confirm-btn" onclick="submitApplication()">Confirm Apply</button>
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

        // Show alert message
        function showAlert(message, type) {
            const alertContainer = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            alert.style.display = 'block';
            
            alertContainer.innerHTML = '';
            alertContainer.appendChild(alert);

            // Auto-hide after 5 seconds
            setTimeout(() => {
                alert.style.display = 'none';
            }, 5000);
        }

        // Close modal if clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('confirmationModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        // Show alert if there's a message in session
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
