<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'green_lease');
define('DB_USER', 'root');
define('DB_PASS', '');

echo "<h2>Database Connection Test</h2>";

try {
    // Attempt to create a PDO connection
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
    
    echo "<p style='color: green;'>✓ Database connection successful!</p>";
    
    // Test if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Users table exists</p>";
        
        // Count total users
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
        $count = $stmt->fetch();
        echo "<p>Total users in database: " . $count['total'] . "</p>";
        
        // Check table structure
        echo "<h3>Users Table Structure:</h3>";
        $stmt = $pdo->query("DESCRIBE users");
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Show a few sample users (without sensitive data)
        echo "<h3>Sample Users (Limited Data):</h3>";
        $stmt = $pdo->query("SELECT id, email, role_id, full_name FROM users LIMIT 5");
        if ($stmt->rowCount() > 0) {
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>ID</th><th>Email</th><th>Role</th><th>Name</th></tr>";
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['role_id'] . "</td>";
                echo "<td>" . $row['full_name'] . "</td>";
                // echo "<td>" . ($row['is_active'] ? 'Yes' : 'No') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No users found in the database.</p>";
        }
        
    } else {
        echo "<p style='color: red;'>✗ Users table does not exist!</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Connection failed: " . $e->getMessage() . "</p>";
    
    // Additional debugging information
    echo "<h3>Debug Information:</h3>";
    echo "<p>Host: " . DB_HOST . "</p>";
    echo "<p>Database: " . DB_NAME . "</p>";
    echo "<p>User: " . DB_USER . "</p>";
    
    // Check if MySQL service is running
    $connection = @fsockopen(DB_HOST, 3306, $errno, $errstr, 5);
    if ($connection) {
        echo "<p style='color: green;'>✓ MySQL server is running on port 3306</p>";
        fclose($connection);
    } else {
        echo "<p style='color: red;'>✗ Could not connect to MySQL server on port 3306</p>";
    }
}
?>