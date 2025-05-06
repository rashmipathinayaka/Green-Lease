<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/sitehead.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/sitehead/fertilizer_requests.css">
    <title>Fertilizer Requests</title>
</head>

<body>
    <?php
    require ROOT . '/views/sitehead/sidebar.php';
    require ROOT . '/views/components/topbar.php';
    ?>

    <div class="section">
        <div class="requests-container">
            <div class="requests-list-container">
                <div class="requests-list">
                    <?php if (!empty($requests)): ?>
                        <?php foreach ($requests as $request): ?>
                            <div class="request-item <?= strtolower($request->status) ?>">
                                <div class="request-summary">
                                    <div class="request-main-info">
                                        <h3><?= htmlspecialchars($request->fertilizer_name) ?></h3>
                                        <p><?= htmlspecialchars($request->project_name) ?> (Land: <?= htmlspecialchars($request->land_id) ?>)</p>
                                    </div>
                                    <span class="request-status <?= strtolower($request->status) ?>">
                                        <?php if ($request->status === 'Approved'): ?>
                                            <i class="fas fa-check-circle"></i> Approved
                                        <?php else: ?>
                                            <i class="fas fa-clock"></i> Pending
                                        <?php endif; ?>
                                    </span>
                                </div>

                                <div class="request-actions">
                                    <button class="action-btn view-details-btn" onclick="event.stopPropagation(); toggleRequestDetails(this.closest('.request-item'))">
                                        <i class="fas fa-eye"></i> View Details
                                    </button>

                                    <?php if ($request->status === 'Pending'): ?>
                                        <button class="action-btn edit-request-btn" onclick="event.stopPropagation(); editRequest(<?= $request->id ?>)">
                                            <i class="fas fa-edit"></i> Edit Request
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <div class="request-details-expanded">
                                    <div class="detail-row">
                                        <span class="detail-label">Amount Requested:</span>
                                        <span class="detail-value"><?= htmlspecialchars($request->amount) ?> kg</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Requested Date:</span>
                                        <span class="detail-value"><?= date('M d, Y', strtotime($request->preferred_date)) ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Remarks:</span>
                                        <span class="detail-value"><?= htmlspecialchars($request->remarks) ?: 'None' ?></span>
                                    </div>

                                    <?php if ($request->status === 'Approved'): ?>
                                        <div class="approval-details">
                                            <h4>Approval Details</h4>
                                            <div class="detail-row">
                                                <span class="detail-label">Approved Amount:</span>
                                                <span class="detail-value"><?= htmlspecialchars($request->approvedAmount) ?> kg</span>
                                            </div>
                                            <div class="detail-row">
                                                <span class="detail-label">Planned Delivery Date: </span>
                                                <span class="detail-value"><?= date('M d, Y', strtotime($request->plannedDate)) ?></span>
                                            </div>
                                            <div class="detail-row">
                                                <span class="detail-label">Additional Notes:</span>
                                                <span class="detail-value"><?= htmlspecialchars($request->AdditionalNotes) ?: 'None' ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-requests">
                            <i class="fas fa-box-open"></i>
                            <p>No fertilizer requests found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        const URLROOT = "<?= URLROOT ?>";

        function toggleRequestDetails(element) {
            const details = element.querySelector('.request-details-expanded');
            details.classList.toggle('show');

            // Scroll to show the expanded content if needed
            if (details.classList.contains('show')) {
                details.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }
        }

        function editRequest(requestId) {
            const confirmation = confirm(
                "Are you sure you want to edit this fertilizer request?"
            );
            if (confirmation) {
                window.location.href = `${URLROOT}/Sitehead/Update_request/editRequest/${requestId}`;
            }
        }

        function closeModal() {
            document.getElementById('requestModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('requestModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>

</html>