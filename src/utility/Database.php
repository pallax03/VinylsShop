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

    public function closeConnection() {
        if ($this->connection !== null) {
            $this->connection->close();
        }
    }
    
    /*
     * Prepare a query with parameters
     * 
     * @param string $query
     * @param string $types
     * @param mixed $params
     * 
     * @return mysqli_stmt 
    */
    private function executeQueryWithParams($query, $types, ...$params) {
        $stmt = $this->connection->prepare($query);
        if ($stmt === false) {
            return false;
        }
        if (!$stmt->bind_param($types, ...$params)) {
            return false;
        }

        $stmt->execute();
        return $stmt;
    }

    /*
     * @param mysqli_stmt $stmt
     * 
     * @return true if the query has thrown an exception, otherwise false
    */
    private function queryThrowException($stmt) {
        return $stmt === false || $stmt->errno !== 0;
    }

    /*
     * Execute a SELECT query
     * 
     * @return array the result of the query if successful, otherwise an empty array
    */
    public function executeResults($query, $types, ...$params) {
        $stmt = $this->executeQueryWithParams($query, $types, ...$params);
        $result = $stmt->get_result();
        if ($this->queryThrowException($stmt) || $result->num_rows === 0) {
            return [];
        }
        return $result->fetch_assoc() ?? [];
    }


    /*
     * Execute a INSERT, UPDATE, DELETE query
     * 
     * @return bool true if the query affected rows, otherwise false
    */
    public function executeQueryAffectRows($query, $types, ...$params) {
        $stmt = $this->executeQueryWithParams($query, $types, ...$params);
        return !$this->queryThrowException($stmt) && $stmt->affected_rows > 0;
    }

}
    
?>