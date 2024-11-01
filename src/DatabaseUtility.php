<?php
    class DatabaseUtility {
        private $host;
        private $username;
        private $password;
        private $database;

        private $connection;

        public function __construct() {
            $this->host = $_ENV['DB_HOST'] ?? 'localhost';
            $this->username = $_ENV['DB_USER'] ?? 'root';
            $this->password = $_ENV['DB_PASSWORD'] ?? '';
            $this->database = $_ENV['DB_NAME'] ?? 'my_sql';
        }

        public function connect() {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
            if ($this->connection->connect_error) {
                die("Connection failed: " . $this->connection->connect_error);
            }
            return $this->connection;
        }

        public function close() {
            $this->connection->close();
        }

        // TODO: implement this method
        public function create() {
            throw new Exception("not implemented", 501);
        }
    }
?>