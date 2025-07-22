<?php
/**
 * Database Configuration
 * This file contains database connection settings
 */

// Database configuration constants for XAMPP
define('DB_HOST', 'localhost');        // Your database host
define('DB_NAME', 'osi_ekiti_db');     // Your database name
define('DB_USER', 'root');             // XAMPP default username
define('DB_PASS', '');                 // XAMPP default password (empty)
define('DB_CHARSET', 'utf8mb4');       // Character set

/**
 * Database Connection Class
 * Similar to how you'd create a database connection in Node.js
 */
class Database {
    private $connection;
    
    public function __construct() {
        $this->connect();
    }
    
    private function connect() {
        try {
            // Create PDO connection (PHP's equivalent to database drivers in Node.js)
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $this->connection = new PDO($dsn, DB_USER, DB_PASS);
            
            // Set error mode to exception (like try/catch in Node.js)
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public function getConnection() {
        return $this->connection;
    }
}
?>
