<?php    
    class DatabaseUtility {
        private static string $host= 'localhost';
        private static string $username= 'root';
        private static string $password= '';
        private static string $database= 'mysql';
        private static string $port= '3306';

        public static $connection = null;

        public static function setConfigEnv() {
            self::$host = $_ENV['DB_HOST'] ?? self::$host;
            self::$username = $_ENV['DB_USER'] ?? self::$username;
            self::$password = $_ENV['DB_PASSWORD'] ?? self::$password;
            self::$database = $_ENV['DB_NAME'] ?? self::$database;
            self::$port = $_ENV['DB_PORT'] ?? self::$port;
        }

        public static function connect() {
            if (self::$connection === null) {
                self::$connection = new mysqli(self::$host, self::$username, self::$password, self::$database);
                if (self::$connection->connect_error) {
                    echo ("Connection failed: " . self::$connection->connect_error);
                    self::$connection = null;
                }
            }
            return self::$connection;
        }
    }
?>