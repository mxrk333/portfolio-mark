<?php
// Database configuration
class Database {
    private $host = 'localhost';
    private $dbname = 'portfolio_db';
    private $username = 'root';
    private $password = '';
    private $pdo;
    
    public function __construct() {
        $this->connect();
    }
    
    private function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch(PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public function getConnection() {
        return $this->pdo;
    }
    
    // Method to test connection
    public function testConnection() {
        try {
            $stmt = $this->pdo->query("SELECT 1");
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }
    
    // Method to create tables if they don't exist
    public function createTables() {
        $sql = "
        CREATE TABLE IF NOT EXISTS inquiries (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(20),
            subject VARCHAR(255),
            message TEXT NOT NULL,
            is_read BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        try {
            $this->pdo->exec($sql);
            return true;
        } catch(PDOException $e) {
            error_log("Error creating tables: " . $e->getMessage());
            return false;
        }
    }
}

// Create a global database instance
$database = new Database();
$pdo = $database->getConnection();

// Ensure tables exist
$database->createTables();
?>
