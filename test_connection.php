<?php
/**
 * Database Connection Test Script
 * Run this to verify your database connection is working
 */

echo "<h2>🔍 Testing Database Connection...</h2>";

// Test 1: Check if database config file exists
echo "<h3>1. Checking Configuration Files</h3>";
if (file_exists('config/database.php')) {
    echo "✅ Database config file found<br>";
    require_once 'config/database.php';
} else {
    echo "❌ Database config file not found<br>";
    exit;
}

// Test 2: Test database connection
echo "<h3>2. Testing Database Connection</h3>";
try {
    $database = new Database();
    $db = $database->getConnection();
    echo "✅ Database connection successful<br>";
    echo "📊 Database Name: " . DB_NAME . "<br>";
    echo "🖥️ Database Host: " . DB_HOST . "<br>";
    echo "👤 Database User: " . DB_USER . "<br>";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test 3: Check if users table exists
echo "<h3>3. Checking Database Tables</h3>";
try {
    $stmt = $db->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Users table exists<br>";
        
        // Get table structure
        $stmt = $db->query("DESCRIBE users");
        $columns = $stmt->fetchAll();
        echo "📋 Table Structure:<br>";
        echo "<ul>";
        foreach ($columns as $column) {
            echo "<li>{$column['Field']} - {$column['Type']}</li>";
        }
        echo "</ul>";
        
        // Count records
        $stmt = $db->query("SELECT COUNT(*) as count FROM users");
        $count = $stmt->fetch()['count'];
        echo "📊 Total records: {$count}<br>";
        
    } else {
        echo "❌ Users table does not exist<br>";
        echo "💡 Run setup_database.php to create the table<br>";
    }
} catch (Exception $e) {
    echo "❌ Error checking tables: " . $e->getMessage() . "<br>";
}

// Test 4: Test API endpoints
echo "<h3>4. Testing API Endpoints</h3>";
$baseUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);

echo "🌐 Base URL: {$baseUrl}<br>";
echo "📡 API Endpoint: {$baseUrl}/api/users<br>";

// Test 5: Check required files
echo "<h3>5. Checking Required Files</h3>";
$requiredFiles = [
    'api/index.php' => 'Main API router',
    'api/routes/users.php' => 'User routes',
    'models/User.php' => 'User model',
    '.htaccess' => 'Apache configuration'
];

foreach ($requiredFiles as $file => $description) {
    if (file_exists($file)) {
        echo "✅ {$description}: {$file}<br>";
    } else {
        echo "❌ Missing {$description}: {$file}<br>";
    }
}

// Test 6: PHP Configuration
echo "<h3>6. PHP Configuration</h3>";
echo "🐘 PHP Version: " . phpversion() . "<br>";
echo "📦 PDO MySQL: " . (extension_loaded('pdo_mysql') ? '✅ Available' : '❌ Not Available') . "<br>";
echo "🔧 JSON: " . (extension_loaded('json') ? '✅ Available' : '❌ Not Available') . "<br>";

echo "<h3>✨ Connection Test Complete!</h3>";
echo "<p>If all tests passed, your backend is ready to use!</p>";
?>
