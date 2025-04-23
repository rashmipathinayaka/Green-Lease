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

<body>
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

<style>
            .report-button {
    background-color: #f44336;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.report-button:hover {
    background-color: #c62828;
}
</style>

            <!-- Add this anywhere in the dashboard section -->
<div style="text-align: right; margin: 20px;"><button>
<a href="<?= URLROOT ?>/Admin/report/" class="report-button">Generate Report</a>
</button>
</div>
















            <div class="charts">
                <div class="chart-box">
                    <div class="chart-title">Project Distribution</div>
                    <canvas id="landPieChart"></canvas>
                <div class="landPieChart">
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const ctx = document.getElementById('landPieChart').getContext('2d');

                        const landPieChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: ['Ongoing', 'Unused', 'Completed'],
                                datasets: [{
                                    label: 'Land count',
                                    data: [<?= $ongoing ?>, <?= $unused ?>, <?= $completed ?>],
                                    backgroundColor: ['#ce39ad', '#22c298', '#d62115'],
                                    borderColor: '#fff',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    },
                                    title: {
                                        display: true,
                                        text: ''
                                    }
                                }
                            }
                        });
                    </script>
                </div>
                </div>



                <div class="chart-box">
                    <div class="chart-title">Lands Registered Per Year</div>
                    <br><br><br><br><br><br><br>
                    <canvas id="landBarChart"></canvas>
                   
                <div class="landBarChart">


                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <br><br>



                    <script>
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
                title: { display: true, text: 'Number of Lands' }
            },
            x: {
                title: { display: true, text: 'Year' }
            }
        }
    }
});

                    </script>
                </div>
            </div></div>
</body>

</html>