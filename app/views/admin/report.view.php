<!-- /views/admin/report_template.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Admin Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .report-container { margin: 20px; }
        h1 { color: #444; }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid #777;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
        }
    </style>
    <!-- Include html2pdf.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
</head>
<body>
<div class="report-container" id="report">
    <h1>Green Lease Summary Report</h1>
    <table>
        <tr>
            <th>Metric</th>
            <th>Count</th>
        </tr>
        <tr>
            <td>Registered Lands</td>
            <td><?= htmlspecialchars($landCount) ?></td>
        </tr>
        <tr>
            <td>Supervisors</td>
            <td><?= htmlspecialchars($supervisorCount) ?></td>
        </tr>
        <tr>
            <td>Total Bids</td>
            <td><?= htmlspecialchars($bidCount) ?></td>
        </tr>
        <tr>
            <td>Buyers</td>
            <td><?= htmlspecialchars($buyerCount) ?></td>
        </tr>
    </table>

    <!-- Button to trigger PDF download -->
    <button id="downloadReport">Download PDF</button>
</div>

<script>
// Add event listener to the button to trigger PDF download
document.getElementById('downloadReport').addEventListener('click', function() {
    const element = document.getElementById('report'); // The section to be downloaded
    const opt = {
        margin:       1,
        filename:     'GreenLeaseReport.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { dpi: 192, letterRendering: true },
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
    };
    html2pdf().from(element).set(opt).save();
});
</script>

</body>
</html>
