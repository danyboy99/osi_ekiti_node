<?php
/**
 * Database Setup Script for XAMPP
 * Run this file once to create the database and table
 */

// Database configuration for XAMPP
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'osi_ekiti_db';

try {
    // First, connect without specifying database to create it
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Database '$database' created successfully!\n";
    
    // Now connect to the specific database
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        family_name VARCHAR(255) NOT NULL,
        phone_no VARCHAR(20) NOT NULL,
        quarters VARCHAR(255) NOT NULL,
        current_address TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "✅ Users table created successfully!\n";
    
    // Create indexes for better performance
    $indexes = [
        "CREATE INDEX IF NOT EXISTS idx_fullname ON users(fullname)",
        "CREATE INDEX IF NOT EXISTS idx_family_name ON users(family_name)",
        "CREATE INDEX IF NOT EXISTS idx_email ON users(email)",
        "CREATE INDEX IF NOT EXISTS idx_quarters ON users(quarters)"
    ];
    
    foreach ($indexes as $index) {
        $pdo->exec($index);
    }
    echo "✅ Database indexes created successfully!\n";
    
    // Insert sample data
    $sampleData = "INSERT IGNORE INTO users (fullname, email, family_name, phone_no, quarters, current_address) VALUES
        ('Adebayo Ogundimu', 'adebayo@example.com', 'Ogundimu', '+234-801-234-5678', 'Isale Osi', 'No. 15 Lagos Street, Lagos, Nigeria'),
        ('Folake Adeyemi', 'folake@example.com', 'Adeyemi', '+234-802-345-6789', 'Oke Osi', 'Plot 23 Abuja Close, Abuja, Nigeria'),
        ('Taiwo Olumide', 'taiwo@example.com', 'Olumide', '+234-803-456-7890', 'Agbado', 'House 7 Ibadan Road, Ibadan, Nigeria')";
    
    $pdo->exec($sampleData);
    echo "✅ Sample data inserted successfully!\n";
    
    echo "\n🎉 Database setup completed successfully!\n";
    echo "You can now test the registration form.\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
