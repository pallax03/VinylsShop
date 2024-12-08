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
    private $handler;

    private static string $host= 'localhost';
    private static string $username= 'user';
    private static string $password= 'password';
    private static string $database= 'mysql';
    private static string $port= '3306';

    // Il costruttore è privato per impedire la creazione diretta di oggetti
    private function __construct() {
        $this->setConfigEnv();

        $this->handler = $this->defaultHandler();

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

    private function defaultHandler() {
        return function($finalQuery, $finalTypes, ...$params) {
            echo 'Query: '.$finalQuery . "</br>";
            echo 'Types: '.$finalTypes . "</br>";
            foreach ($params as $param) {
                echo ($param === null ? "NULL" : $param) . " ";
            }
        };
    }

    public function setHandler($handler) {
        $this->handler = $handler;
    }

    /*
     * Execute a query with parameters, filtering null values
     * It allows to use optional parameters:
     * parsing the query given, it will bind only the parameters that are not null
     * U need to pass the final query:
     * and ALL the parameters to bind
     *  
     * 
     * @param string $query the query already prepared
     * @param string $types the types of the parameters, and optional
     * @param mixed ...$params all the parameters to bind, also optional
     * 
     * @return mysqli_stmt the statement if successful, otherwise false
    */
    private function executeQueryWithParams($query, $types, ...$params) {
        // Build the final query and filter parameters
        $finalQuery = '';
        $finalParams = [];
        $finalTypes = '';

        // Split the query by conditionals (e.g., for WHERE clauses)
        $queryParts = explode('?', $query);

        // echo 'Query: '.$query . "</br>";
        foreach ($queryParts as $i => $part) {
            $finalQuery .= $part;
            if ($i < count($params) && $params[$i] !== null) {
                $finalQuery .= '?';
                $finalParams[$i] = $params[$i] === '' ? null : $params[$i];
                $finalTypes .= $types[$i];
            }
        }

        try {
            $stmt = $this->connection->prepare($finalQuery);    
            $stmt->bind_param($finalTypes, ...$finalParams);
            $stmt->execute();
        } catch (\Throwable $th) {
            echo 'Handler: </br>';
            call_user_func($this->handler, $finalQuery, $finalTypes, ...$finalParams);
            echo '</br>';
            return false;
        }

        
        return $stmt;
    }

    private function executeQuery($query) {
        $stmt = $this->connection->prepare($query);
        if ($stmt === false) {
            return false;
        }

        $stmt->execute();
        return $stmt;
    }

    /*
     * Check if the query has thrown an exception, maybe i can put an hanlder !!!
     * 
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
    public function executeResults($query, $types=null, ...$params) {
        $stmt = $types === null || empty($types) ? $this->executeQuery($query) : $this->executeQueryWithParams($query, $types, ...$params);
        $result = $stmt->get_result();
        if ($this->queryThrowException($stmt) || $result->num_rows === 0) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC) ?? [];
    }


    /*
     * Execute a INSERT, UPDATE, DELETE query
     * 
     * @return bool true if the query affected rows, otherwise false
    */
    public function executeQueryAffectRows($query, $types=null, ...$params) {
        $stmt = $types === null || empty($types) ? $this->executeQuery($query) : $this->executeQueryWithParams($query, $types, ...$params);
        return !$this->queryThrowException($stmt) && $stmt->affected_rows > 0;
    }

}
    
?>