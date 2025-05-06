<div class="request-details-modal">
    <h2><?= htmlspecialchars($request->fertilizer_name) ?> Request</h2>

    <div class="detail-section">
        <h3>Request Information</h3>
        <p><strong>Project:</strong> <?= htmlspecialchars($request->project_name) ?></p>
        <p><strong>Land ID:</strong> <?= htmlspecialchars($request->land_id) ?></p>
        <p><strong>Original Requested Amount:</strong> <?= htmlspecialchars($request->amount) ?> kg</p>
        <p><strong>Requested Delivery Date:</strong> <?= date('M d, Y', strtotime($request->preferred_date)) ?></p>
        <p><strong>Status:</strong> <span class="status-<?= strtolower($request->status) ?>"><?= $request->status ?></span></p>
        <p><strong>Remarks:</strong> <?= htmlspecialchars($request->remarks) ?: 'None' ?></p>
    </div>

    <?php if ($request->status === 'Approved'): ?>
        <div class="detail-section approved-details">
            <h3>Approval Details</h3>
            <p><strong>Approved Amount:</strong> <?= htmlspecialchars($request->approvedAmount) ?> kg</p>
            <p><strong>Planned Delivery Date:</strong> <?= date('M d, Y', strtotime($request->plannedDate)) ?></p>
            <p><strong>Additional Notes:</strong> <?= htmlspecialchars($request->AdditionalNotes) ?: 'None' ?></p>
        </div>
    <?php endif; ?>
</div>