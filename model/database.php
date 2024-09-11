<?php
class Database {
    private static $instance = null;
    private $conn;

    private function __construct($dsn, $username, $password) {
        try {
            $this->conn = new PDO($dsn, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database('mysql:host=localhost;dbname=db_users', 'root', '');
        }
        return self::$instance;
    }

    public function getData() {
        if ($this->conn) {
            try {
                $stmt = $this->conn->query("SELECT * FROM users");
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log("Query failed: " . $e->getMessage());
                return [];
            }
        } else {
            error_log("No connection.");
            return [];
        }
    }

    public function __destruct() {
        $this->conn = null;
    }
}
?>