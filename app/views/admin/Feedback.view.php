

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Management System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
            color: #333;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        
        /* Tab styling */
        .tabs {
            display: flex;
            margin-bottom: 20px;
        }
        
        .tab-button {
            flex: 1;
            padding: 15px;
            font-size: 16px;
            font-weight: bold;
            background-color: #e0e0e0;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .tab-button:hover {
            background-color: #d0d0d0;
        }
        
        .tab-button.active {
            background-color: #3498db;
            color: white;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        /* Feedback card styling */
        .feedback-section {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .feedback-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.2s;
        }
        
        .feedback-card:hover {
            transform: translateY(-5px);
        }
        
        .feedback-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        
        .from-user {
            font-weight: bold;
            color: #3498db;
        }
        
        .project-id {
            font-size: 0.9em;
            color: #7f8c8d;
        }
        
        .view-project {
            display: inline-block;
            background-color: #2ecc71;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.8em;
            margin-left: 5px;
        }
        
        .feedback-content {
            margin-bottom: 15px;
            word-wrap: break-word;
        }
        
        .feedback-actions {
            display: flex;
            justify-content: flex-end;
        }
        
        .button {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .solve-button {
            background-color: #3498db;
            color: white;
        }
        
        .solve-button:hover {
            background-color: #2980b9;
        }
        
        .delete-button {
            background-color: #e74c3c;
            color: white;
        }
        
        .delete-button:hover {
            background-color: #c0392b;
        }
        
        .solved-info {
            font-size: 0.9em;
            color: #27ae60;
            margin-bottom: 10px;
        }
        
        .no-feedback {
            text-align: center;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            grid-column: 1 / -1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Feedback Management System</h1>
        
        <!-- Tabs -->
        <div class="tabs">
            <button class="tab-button active" onclick="openTab('unsolved')">Unsolved Feedbacks</button>
            <button class="tab-button" onclick="openTab('solved')">Solved Feedbacks</button>
        </div>
        
        <!-- Unsolved Feedbacks Tab -->
        <div id="unsolved" class="tab-content active">
            <div class="feedback-section">
                <?php if ($unsolved_result->num_rows > 0): ?>
                    <?php while($row = $unsolved_result->fetch_assoc()): ?>
                        <div class="feedback-card">
                            <div class="feedback-header">
                                <div>
                                    <span class="from-user">From: <?php echo htmlspecialchars($row['from_username']); ?></span>
                                </div>
                                <div class="project-id">
                                    Project ID: <?php echo htmlspecialchars($row['project_id']); ?>
                                    <a href="view_project.php?id=<?php echo $row['project_id']; ?>" class="view-project">View</a>
                                </div>
                            </div>
                            <div class="feedback-content">
                                <?php echo htmlspecialchars($row['feedback_text']); ?>
                            </div>
                            <div class="feedback-actions">
                                <form method="post">
                                    <input type="hidden" name="feedback_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="mark_solved" class="button solve-button">Mark as Solved</button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-feedback">No unsolved feedbacks found!</div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Solved Feedbacks Tab -->
        <div id="solved" class="tab-content">
            <div class="feedback-section">
                <?php if ($solved_result->num_rows > 0): ?>
                    <?php while($row = $solved_result->fetch_assoc()): ?>
                        <div class="feedback-card">
                            <div class="feedback-header">
                                <div>
                                    <span class="from-user">From: <?php echo htmlspecialchars($row['from_username']); ?></span>
                                </div>
                                <div class="project-id">
                                    Project ID: <?php echo htmlspecialchars($row['project_id']); ?>
                                    <a href="view_project.php?id=<?php echo $row['project_id']; ?>" class="view-project">View</a>
                                </div>
                            </div>
                            <div class="feedback-content">
                                <?php echo htmlspecialchars($row['feedback_text']); ?>
                            </div>
                            <div class="solved-info">
                                Solved by: <?php echo htmlspecialchars($row['solved_username']); ?>
                            </div>
                            <div class="feedback-actions">
                                <form method="post" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                                    <button type="submit" name="delete_feedback" value="<?php echo $row['id']; ?>" class="button delete-button">Delete</button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-feedback">No solved feedbacks found!</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function openTab(tabName) {
            // Hide all tab contents
            const tabContents = document.getElementsByClassName('tab-content');
            for (let i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove('active');
            }
            
            // Deactivate all tab buttons
            const tabButtons = document.getElementsByClassName('tab-button');
            for (let i = 0; i < tabButtons.length; i++) {
                tabButtons[i].classList.remove('active');
            }
            
            // Show the selected tab content and activate the button
            document.getElementById(tabName).classList.add('active');
            event.currentTarget.classList.add('active');
        }
    </script>
</body>
</html>