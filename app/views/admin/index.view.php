<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="admin.js" defer></script>

</head>

<body style="margin-top: -40px;">
    <?php

    require ROOT . '/views/admin/sidebar.php';
    require ROOT . '/views/components/topbar.php';

    ?>

    <div class="admin-container">

        <div class="content">
            <div id="dashboard-section">
                <div class="metric-grid">
                    <div class="metric-card">
                        <h3>Registered Lands</h3>
                        <div class="metric-content">
                            <span class="metric-value">
                                <?php echo !empty($landCount) ? htmlspecialchars($landCount) : 1; ?>

                            </span>
                            <i class="fas fa-seedling"></i>
                        </div>
                        <button onclick="window.location.href='<?= URLROOT ?>/admin/manage_land/'">View</button>
                    </div>
                    <div class="metric-card">
                        <h3>Supervisor Count</h3>
                        <div class="metric-content">
                            <span class="metric-value"> 
                                <?php echo !empty($supervisorcount) ? htmlspecialchars($supervisorcount) : 1; ?></span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button onclick="window.location.href='<?= URLROOT ?>/admin/manage_supervisor/'">View</button>
                    </div>
                    <div class="metric-card">
                        <h3>Total Bids</h3>
                        <div class="metric-content">
                            <span class="metric-value">
                                <?php echo !empty($bidCount) ? htmlspecialchars($bidCount) : 1; ?>

                            </span>
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <button onclick="window.location.href='<?= URLROOT ?>/admin/manage_bids/'">View</button>
                    </div>
                    <div class="metric-card">
                        <h3>Buyer Count</h3>
                        <div class="metric-content">
                            <span class="metric-value">240</span>
                            <i class="fas fa-user"></i>
                        </div>
                        <button onclick="showSection('manage-buyers-section')">View</button>
                    </div>
                </div>

              
            </div>

            <div class="dashboard-section">
                <div class="section-header">
                    <h2>Analytics Dashboard</h2>
                    <a href="<?= URLROOT ?>/Admin/report/" class="report-button">
                        <i class="fas fa-file-alt"></i>
                        Generate Report
                    </a>
                    <a href="<?= URLROOT ?>/Admin/statistics/" class="report-button">
                        <i class="fas fa-chart-line"></i>
                        View Statistics
                    </a>
                </div>

                <div class="charts-container">
                    <div class="chart-box">
                        <div class="chart-header">
                            <h3>Project Distribution</h3>
                            <div class="chart-legend">
                                <span class="legend-item"><span class="legend-color" style="background: #ce39ad"></span>Ongoing</span>
                                <span class="legend-item"><span class="legend-color" style="background: #22c298"></span>Unused</span>
                                <span class="legend-item"><span class="legend-color" style="background: #d62115"></span>Completed</span>
                            </div>
                        </div>
                        <div class="chart-content">
                            <canvas id="landPieChart"></canvas>
                        </div>
                    </div>

                    <div class="chart-box">
                        <div class="chart-header">
                            <h3>Lands Registered Per Year</h3>
                        </div>
                        <div class="chart-content">
                            <canvas id="landBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Pie Chart
        const ctx = document.getElementById('landPieChart').getContext('2d');
        const landPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Ongoing', 'Unused', 'Completed'],
                datasets: [{
                    data: [<?= $ongoing ?>, <?= $unused ?>, <?= $completed ?>],
                    backgroundColor: ['#ce39ad', '#22c298', '#d62115'],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Bar Chart
        const barctx = document.getElementById('landBarChart').getContext('2d');
        const landBarChart = new Chart(barctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($yearLabels); ?>,
                datasets: [{
                    label: 'Lands Registered',
                    data: <?= json_encode($yearData); ?>,
                    backgroundColor: 'rgba(66, 191, 52, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1500,
                    easing: 'easeOutBounce'
                },
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { 
                            display: true, 
                            text: 'Number of Lands',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        title: { 
                            display: true, 
                            text: 'Year',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>