<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'green_lease');
define('DB_USER', 'root');
define('DB_PASS', '');


$pdo = new PDO(
    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
    DB_USER,
    DB_PASS,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]
);

$stmt = $pdo->query("SELECT *  FROM worker_complaint");
        if ($stmt->rowCount() > 0) {
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>ID</th><th>Email</th><th>Role</th><th>Name</th></tr>";
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['worker_id'] . "</td>";
                echo "<td>" . $row['complaint_type'] . "</td>";
                echo "<td>" . $row['site_address'] . "</td>";
                // echo "<td>" . ($row['is_active'] ? 'Yes' : 'No') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No users found in the database.</p>";
        }