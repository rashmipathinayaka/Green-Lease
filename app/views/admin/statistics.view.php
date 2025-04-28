<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Statistics</title>
    <link rel="stylesheet" href="/Green-Lease/app/assets/css/admin/statistics.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>System Statistics Dashboard</h2>
            <button id="downloadPdf" class="download-button">
                <i class="fas fa-download"></i>
                Download PDF
            </button>
        </div>

        <div id="contentToPrint">
            <!-- Quality Metrics Section -->
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-chart-line"></i> Quality Metrics</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h5><i class="fas fa-star"></i> Overall Rating</h5>
                                <p class="stat-value"><?= isset($quality_metrics->overall_rating) ? number_format($quality_metrics->overall_rating, 1) : '0.0' ?>/5</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h5><i class="fas fa-check-circle"></i> High Quality Projects</h5>
                                <p class="stat-value"><?= isset($quality_metrics->high_quality_projects) ? $quality_metrics->high_quality_projects : '0' ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h5><i class="fas fa-project-diagram"></i> Total Projects</h5>
                                <p class="stat-value"><?= isset($quality_metrics->total_projects) ? $quality_metrics->total_projects : '0' ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h5><i class="fas fa-percentage"></i> Quality Percentage</h5>
                                <p class="stat-value"><?= isset($quality_metrics->quality_percentage) ? number_format($quality_metrics->quality_percentage, 1) : '0.0' ?>%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Zone Performance Section -->
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-map-marked-alt"></i> Zone Performance</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-map-marker-alt"></i> Zone</th>
                                    <th><i class="fas fa-project-diagram"></i> Total Projects</th>
                                    <th><i class="fas fa-money-bill-wave"></i> Total Income</th>
                                    <th><i class="fas fa-star"></i> Average Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($zone_performance)): ?>
                                    <?php foreach ($zone_performance as $zone): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($zone->zone) ?></td>
                                        <td><?= $zone->total_projects ?></td>
                                        <td>Rs. <?= isset($zone->total_income) ? number_format($zone->total_income, 2) : '0.00' ?></td>
                                        <td><?= isset($zone->average_rating) ? number_format($zone->average_rating, 1) : '0.0' ?>/5</td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No zone performance data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Crop Performance Section -->
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-seedling"></i> Crop Performance</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-leaf"></i> Crop Type</th>
                                    <th><i class="fas fa-project-diagram"></i> Total Projects</th>
                                    <th><i class="fas fa-money-bill-wave"></i> Total Income</th>
                                    <th><i class="fas fa-star"></i> Average Rating</th>
                                    <th><i class="fas fa-weight"></i> Average Yield</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($crop_performance)): ?>
                                    <?php foreach ($crop_performance as $crop): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($crop->crop_type) ?></td>
                                        <td><?= $crop->total_projects ?></td>
                                        <td>Rs. <?= isset($crop->total_income) ? number_format($crop->total_income, 2) : '0.00' ?></td>
                                        <td><?= isset($crop->average_rating) ? number_format($crop->average_rating, 1) : '0.0' ?>/5</td>
                                        <td><?= isset($crop->average_yield) ? number_format($crop->average_yield, 2) : '0.00' ?> kg</td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No crop performance data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Project Timeline Section -->
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-calendar-alt"></i> Project Timeline (Current Year)</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-calendar"></i> Month</th>
                                    <th><i class="fas fa-play-circle"></i> Projects Started</th>
                                    <th><i class="fas fa-check-circle"></i> Projects Completed</th>
                                    <th><i class="fas fa-money-bill-wave"></i> Monthly Income</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($project_timeline)): ?>
                                    <?php foreach ($project_timeline as $month): ?>
                                    <tr>
                                        <td><?= date('F', mktime(0, 0, 0, $month->month, 1)) ?></td>
                                        <td><?= $month->projects_started ?></td>
                                        <td><?= $month->projects_completed ?></td>
                                        <td>Rs. <?= isset($month->monthly_income) ? number_format($month->monthly_income, 2) : '0.00' ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No project timeline data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Staff Performance Section -->
            <div class="row">
                <!-- Supervisor Performance -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-user-tie"></i> Supervisor Performance</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><i class="fas fa-user"></i> Name</th>
                                            <th><i class="fas fa-project-diagram"></i> Projects</th>
                                            <th><i class="fas fa-money-bill-wave"></i> Income</th>
                                            <th><i class="fas fa-star"></i> Rating</th>
                                            <th><i class="fas fa-clock"></i> Avg Duration</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($supervisor_performance)): ?>
                                            <?php foreach ($supervisor_performance as $supervisor): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($supervisor->supervisor_name) ?></td>
                                                <td><?= $supervisor->total_projects ?></td>
                                                <td>Rs. <?= isset($supervisor->total_income) ? number_format($supervisor->total_income, 2) : '0.00' ?></td>
                                                <td><?= isset($supervisor->average_rating) ? number_format($supervisor->average_rating, 1) : '0.0' ?>/5</td>
                                                <td><?= isset($supervisor->avg_project_duration) ? number_format($supervisor->avg_project_duration, 1) : '0.0' ?> days</td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No supervisor data available</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sitehead Performance -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-user-shield"></i> Sitehead Performance</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><i class="fas fa-user"></i> Name</th>
                                            <th><i class="fas fa-project-diagram"></i> Projects</th>
                                            <th><i class="fas fa-money-bill-wave"></i> Income</th>
                                            <th><i class="fas fa-star"></i> Rating</th>
                                            <th><i class="fas fa-clock"></i> Avg Duration</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($sitehead_performance)): ?>
                                            <?php foreach ($sitehead_performance as $sitehead): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($sitehead->sitehead_name) ?></td>
                                                <td><?= $sitehead->total_projects ?></td>
                                                <td>Rs. <?= isset($sitehead->total_income) ? number_format($sitehead->total_income, 2) : '0.00' ?></td>
                                                <td><?= isset($sitehead->average_rating) ? number_format($sitehead->average_rating, 1) : '0.0' ?>/5</td>
                                                <td><?= isset($sitehead->avg_project_duration) ? number_format($sitehead->avg_project_duration, 1) : '0.0' ?> days</td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No sitehead data available</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('downloadPdf').addEventListener('click', function() {
            const element = document.getElementById('contentToPrint');
            const opt = {
                margin: 1,
                filename: 'statistics-report.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            // Show loading indicator
            const button = this;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating PDF...';
            button.disabled = true;

            // Generate PDF
            html2pdf().set(opt).from(element).save().then(() => {
                // Restore button state
                button.innerHTML = originalText;
                button.disabled = false;
            });
        });
    </script>
</body>
</html> 