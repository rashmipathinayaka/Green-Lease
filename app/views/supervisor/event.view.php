<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/CSS/supervisor/event.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Manage Events</title>
    <style>
        body {
            padding-top: 70px;
            margin: 0;
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-content {
            margin: 10px 20px;
            position: relative;
            z-index: 1;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .page-title {
            color: #2e7d32;
            font-size: 28px;
            font-weight: 600;
            margin: 0;
        }
        
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 16px;
        }
        
        .project-card {
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
            overflow: hidden;
            height: 90%;
            display: flex;
            flex-direction: column;
        }
        
        .project-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .card-img-container {
            height: 140px;
            overflow: hidden;
            position: relative;
        }
        
        .card-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        
        .project-card:hover .card-img-container img {
            transform: scale(1.05);
        }
        
        .card-status {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            color: white;
            background-color: #4CAF50;
        }
        
        .status-Ongoing {
            background-color: #2196F3;
        }
        
        .status-Completed {
            background-color: #4CAF50;
        }
        
        .status-Pending {
            background-color: #FF9800;
        }
        
        .card-content {
            padding: 10px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 8px 0;
            color: #333;
        }
        
        .card-info {
            font-size: 16px;
            color: #666;
            margin: 3px 0;
            display: flex;
            align-items: center;
        }
        
        .card-info i {
            width: 16px;
            margin-right: 6px;
            color: #2e7d32;
        }
        
        .card-actions {
            padding: 12px;
            border-top: 1px solid #f0f0f0;
            text-align: right;
        }
        
        .view-events-btn {
            background-color: #2e7d32;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
            transition: background-color 0.2s;
            display: inline-flex;
            align-items: center;
        }
        
        .view-events-btn i {
            margin-right: 5px;
        }
        
        .view-events-btn:hover {
            background-color: #1b5e20;
        }
        
        .empty-state {
            grid-column: 1/-1;
            text-align: center;
            padding: 40px 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .empty-state p {
            color: #666;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .projects-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }
        
        @media (max-width: 480px) {
            .projects-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <?php
    require ROOT . '/views/supervisor/sidebar.php';
    require ROOT . '/views/components/topbar.php';
    ?>

    <div class="main-content">
        <div class="page-header">
            <h1 class="page-title"><i>Projects of the Zone</i></h1>
        </div>

        <div class="projects-grid">
            <?php if (!empty($project)) : ?>
                <?php foreach ($project as $item) : ?>
                    <div class="project-card">
                        <div class="card-img-container">
                            <img src="<?php echo URLROOT; ?>/assets/images/hero.jpg" alt="Project Image" />
                            <div class="card-status status-<?php echo htmlspecialchars($item->status ?? 'Pending'); ?>">
                                <?php echo htmlspecialchars($item->status ?? 'Pending'); ?>
                            </div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">
                                <?php echo htmlspecialchars($item->crop_type ?? 'Unknown Crop'); ?>
                            </h3>
                            <p class="card-info">
                                <i class="fas fa-hashtag"></i>
                                Project ID: <?php echo htmlspecialchars($item->id ?? 'N/A'); ?>
                            </p>
                            <p class="card-info">
                                <i class="fas fa-calendar-alt"></i>
                                Started: <?php echo htmlspecialchars($item->start_date ?? 'Not started'); ?>
                            </p>
                            <?php if (!empty($item->end_date)): ?>
                            <p class="card-info">
                                <i class="fas fa-flag-checkered"></i>
                                Completed: <?php echo htmlspecialchars($item->end_date); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                        <div class="card-actions">
                            <form action="<?= URLROOT ?>/Supervisor/Event/viewEvents" method="POST">
                                <input type="hidden" name="project_id" value="<?php echo $item->id ?? ''; ?>">
                                <button type="submit" class="view-events-btn">
                                    <i class="fas fa-calendar-week"></i> View Events
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="empty-state">
                    <p>No projects found. Projects assigned to you will appear here.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>
