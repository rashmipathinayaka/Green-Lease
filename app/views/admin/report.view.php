<!-- /views/admin/report_template.php -->
<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/report.css">

    <!-- Include html2pdf.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
</head>

<body>
    <div class="report-container" id="report">
        <div class="report-header">
            <h1>Green Lease Summary Report</h1>
            <div class="report-date">Generated on: <?= date('F j, Y') ?></div>
        </div>

        <div class="metric-card">
            <div class="metric-item">
                <div class="metric-label">Registered Lands</div>
                <div class="metric-value"><?= htmlspecialchars($landCount) ?></div>
            </div>
            <div class="metric-item">
                <div class="metric-label">Supervisors</div>
                <div class="metric-value"><?= htmlspecialchars($supervisorCount) ?></div>
            </div>
            <div class="metric-item">
                <div class="metric-label">Total Bids</div>
                <div class="metric-value"><?= htmlspecialchars($bidCount) ?></div>
            </div>
            <div class="metric-item">
                <div class="metric-label">Buyers</div>
                <div class="metric-value"><?= htmlspecialchars($buyerCount) ?></div>
            </div>
        </div>

        <h2>Crop Data</h2>
        <div class="highlight-box">
            <div class="data-point">
                Most Selected Crop: <strong><?= htmlspecialchars($mostselectedcrop['crop_type']) ?></strong>
                (Used in <?= htmlspecialchars($mostselectedcrop['count']) ?> projects)
            </div>
            <div class="data-point">
                Most Preferred Crop by Landowners: <strong><?= htmlspecialchars($mostprefferedCrop['crop_type']) ?></strong>
            </div>
            <div class="data-point">
                Success Rate: <span class="success-rate"><?= htmlspecialchars($successrate) ?>%</span>
                (Rate of getting the preferred crop type as the selected crop)
            </div>
        </div>

    <h2>Event Data</h2>
    <div class="highlight-box">
    <div class="data-point">
        Number of events which got postponed this year: <strong><?= htmlspecialchars($postponed) ?></strong><br>
    </div>
        <div class="data-point">
 Number of total events in this year: <strong><?= htmlspecialchars($totalevents) ?></strong><br>
        </div>       <div class="data-point">
 
 The rate of postponing an event: <strong><?= htmlspecialchars($eventpostponedrate) .'%'?></strong>
</div>
    </div>
    
    <h2>Land Data</h2>
    <div class="highlight-box">
        <div class="data-point">
            Most projects are from <strong><?= htmlspecialchars($mostlandzone['zone_name']) ?></strong> District
            (Project Count: <?= htmlspecialchars($mostlandzone['count']) ?>)
        </div>
    </div>

    <h2>Financial Data</h2>
    <div class="highlight-box">
        <div class="data-point">
            Total Income from Completed Projects: <strong>Rs. <?= number_format($totalIncome, 2) ?></strong>
        </div>
        <div class="data-point">
            Most Profitable Crop: 
            <?php if ($mostProfitableCrop): ?>
                <strong><?= htmlspecialchars($mostProfitableCrop->crop_type) ?></strong>
                (Total Income: Rs. <?= number_format($mostProfitableCrop->total_income, 2) ?>)
            <?php else: ?>
                <strong>No data available</strong>
            <?php endif; ?>
        </div>
        <div class="data-point">
            Most Contributing Supervisor: 
            <?php if ($mostContributingSupervisor): ?>
                <strong><?= htmlspecialchars($mostContributingSupervisor->user_name) ?></strong>
                (Total Contribution: Rs. <?= number_format($mostContributingSupervisor->total_contribution, 2) ?>)
            <?php else: ?>
                <strong>No data available</strong>
            <?php endif; ?>
        </div>
        <div class="data-point">
            Most Contributing Sitehead: 
            <?php if ($mostContributingSitehead): ?>
                <strong><?= htmlspecialchars($mostContributingSitehead->user_name) ?></strong>
                (Total Contribution: Rs. <?= number_format($mostContributingSitehead->total_contribution, 2) ?>)
            <?php else: ?>
                <strong>No data available</strong>
            <?php endif; ?>
        </div>
    </div>

    <h3>Income by Crop Type</h3>
    <div class="highlight-box">
        <table class="income-table">
            <thead>
                <tr>
                    <th>Crop Type</th>
                    <th>Total Income</th>
                </tr>
            </thead>
            <tbody>
                <?php if (is_array($incomeByCropType) && count($incomeByCropType) > 0): ?>
                    <?php foreach ($incomeByCropType as $crop): ?>
                    <tr>
                        <td><?= htmlspecialchars($crop->crop_type) ?></td>
                        <td>Rs. <?= number_format($crop->total_income, 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center">No data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

        <div class="footer-note">
            This report was automatically generated by the Green Lease System. For any questions, please contact support.
        </div>
    


    <br>
    <!-- Button to trigger PDF download -->
    <button id="downloadReport">Download PDF</button>
    </div>

    <script>
        // Add event listener to the button to trigger PDF download
        document.getElementById('downloadReport').addEventListener('click', function() {
            const element = document.getElementById('report'); // The section to be downloaded
            const opt = {
                margin: 1,
                filename: 'GreenLeaseReport.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    dpi: 192,
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'portrait'
                }
            };
            html2pdf().from(element).set(opt).save();
        });
    </script>

</body>

</html>