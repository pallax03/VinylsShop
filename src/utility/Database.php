<?php    

/* 
 * UTILITY . Database.php
 * 
 * singleton class to manage database connection
 * it uses the mysqli extension
*/
class Database {
    private static $instance = null;
    private $connection;

    private static string $host= 'localhost';
    private static string $username= 'user';
    private static string $password= 'password';
    private static string $database= 'mysql';
    private static string $port= '3306';

    // Il costruttore è privato per impedire la creazione diretta di oggetti
    private function __construct() {
        $this->setConfigEnv();
    
        $this->connection = new mysqli(self::$host, self::$username, self::$password, self::$database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    private function setConfigEnv() {
        self::$host = $_ENV['DB_HOST'] ?? self::$host;
        self::$username = $_ENV['DB_USER'] ?? self::$username;
        self::$password = $_ENV['DB_PASSWORD'] ?? self::$password;
        self::$database = $_ENV['DB_NAME'] ?? self::$database;
        self::$port = $_ENV['DB_PORT'] ?? self::$port;
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function query($query) {
        return $this->connection->query($query);
    }

    public function closeConnection() {
        if ($this->connection !== null) {
            $this->connection->close();
        }
    }
}
    
?>