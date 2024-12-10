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
    private $got_exception;

    private static string $host= 'localhost';
    private static string $username= 'user';
    private static string $password= 'password';
    private static string $database= 'mysql';
    private static string $port= '3306';

    
    private function __construct() {
        $this->setConfigEnv();
        $this->handler = $this->defaultHandler();
        $this->got_exception = false;
        $this->connection = new mysqli(self::$host, self::$username, self::$password, self::$database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    /**
     * Set the configuration from the environment variables
     *
     * @return void
     */
    private function setConfigEnv() {
        self::$host = $_ENV['DB_HOST'] ?? self::$host;
        self::$username = $_ENV['DB_USER'] ?? self::$username;
        self::$password = $_ENV['DB_PASSWORD'] ?? self::$password;
        self::$database = $_ENV['DB_NAME'] ?? self::$database;
        self::$port = $_ENV['DB_PORT'] ?? self::$port;
    }

    /**
     * Get the instance of the Database class (Singleton)
     *
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Get the connection to the database.
     *
     * @return mysqli_connection
     */
    public function getConnection() {
        return $this->connection;
    }

    /**
     * Close the connection to the database.
     *
     * @return void
     */
    public function closeConnection() {
        if ($this->connection !== null) {
            $this->connection->close();
        }
    }

    private function defaultHandler() {
        return function($query, $types=null, ...$params) {
            echo 'Query: '.$query . "</br>";
            if ($types !== null) {
                echo 'Types: '.$types . "</br>";
                foreach ($params as $param) {
                    echo ($param === null ? "NULL" : $param) . " ";
                }
            }
        };
    }

    /**
     * Set the handler to manage the exceptions
     *
     * @param callable $handler
     * @return void
     */
    public function setHandler($handler) {
        $this->handler = $handler;
    }


    /**
     * Check if the last query has thrown an exception.
     *
     * @return bool
     */
    public function GotException() {
        return $this->got_exception;
    }


    /**
     * Check if the query has thrown an exception
     *
     * @param my_sqli_stmt $stmt
     * @return bool true if the query has thrown an exception, otherwise false
     */
    private function queryThrowException($stmt) {
        return $this->got_exception = $stmt === false || $stmt->errno !== 0;
    }


    /**
     * Execute a query with parameters
     * Parsing the query and the parameters:
     * - if null is passed, the params will not be binded
     * - if empty is passed, it will be replaced with null
     * 
     * IMPORTANT NOTES:
     * - the query must be already prepared with the ? placeholders
     * - the types and the params must be in the same order
     *
     * @param string $query the query already prepared
     * @param [type] $types the types of the parameters, and optional
     * @param [type] ...$params all the parameters to bind, also optional
     * @return mysqli_stmt the result of the query
     */
    private function executeQueryWithParams($query, $types, ...$params) {
        // Build the final query and filter parameters
        $finalQuery = '';
        $finalParams = [];
        $finalTypes = '';

        // Split the query by conditionals (e.g., for WHERE clauses)
        $splitQuery = explode('?', $query);

        // parsing the query
        for ($i = 0; $i < count($splitQuery); $i++) { 
            $finalQuery .= $splitQuery[$i];
            if ($i < count($splitQuery) - 1) {
                $finalQuery .= '?';
                $finalTypes .= $types[$i];
                $finalParams[$i] = $params[$i] === '' ? null : $params[$i];
            }
        }
        // var_dump($finalQuery);
        // var_dump($finalTypes);
        // var_dump($finalParams);

        try {
            $stmt = $this->connection->prepare($finalQuery);    
            $stmt->bind_param($finalTypes, ...$finalParams);
            $stmt->execute();
        } catch (\Throwable $th) {
            if ($this->handler !== null) {
                echo 'Query: </br>';
                call_user_func($this->handler, $query, $types, ...$params);
                echo '</br>';
                echo 'Query Parsed: </br>';
                call_user_func($this->handler, $finalQuery, $finalTypes, ...$finalParams);
                echo '</br>';
                var_dump($th->getMessage());
            }
            return false;
        }

        $this->setHandler($this->defaultHandler());
        return $stmt;
    }


    /**
     * Execute a generic query without parameters
     *
     * @param string $query the query
     * @return array the result of the query
     */
    private function executeQuery($query) {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
        } catch (\Throwable $th) {
            if ($this->handler !== null) {
                echo 'Query: </br>';
                call_user_func($this->handler, $query);
                echo '</br>';
                var_dump($th->getMessage());
            }
            return false;
        }
        return $stmt;
    }


    /**
     * Execute a query that return rows
     * Use for SELECTs
     *
     * @param string $query the query already prepared
     * @param string $types the types of the parameters, and optional
     * @param [...] ...$params all the parameters to bind, also optional
     * @return array the result of the query
     */
    public function executeResults($query, $types=null, ...$params) {
        $stmt = $types === null || empty($types) ? $this->executeQuery($query) : $this->executeQueryWithParams($query, $types, ...$params);
        $result = $stmt->get_result();
        $this->queryThrowException($stmt);
        if ( $this->got_exception || $result->num_rows === 0) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC) ?? [];
    }


    /**
     * Execute a query that return a single row
     * Use for INSERT, UPDATE, DELETE
     * 
     * @param [type] $query the query already prepared
     * @param [type] $types the types of the parameters, and optional
     * @param [type] ...$params all the parameters to bind, also optional
     * @return bool true if the query has affected rows, otherwise false
     */
    public function executeQueryAffectRows($query, $types=null, ...$params) {
        $stmt = $types === null || empty($types) ? $this->executeQuery($query) : $this->executeQueryWithParams($query, $types, ...$params);
        $this->queryThrowException($stmt);
        return !$this->got_exception && $stmt->affected_rows > 0;
    }
}
?>