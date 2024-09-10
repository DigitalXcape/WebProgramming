<?php
class Database {
    private $conn;

    public function __construct($dsn, $username, $password) {
        try {
            $this->conn = new PDO($dsn, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getData() {
        if ($this->conn) {
            try {
                $stmt = $this->conn->query("SELECT * FROM users");
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Query failed: " . $e->getMessage();
                return [];
            }
        } else {
            echo "No connection.";
            return [];
        }
    }

    public function __destruct() {
        $this->conn = null; // Ensure the connection is closed
    }
}
?>