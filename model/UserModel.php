<?php
require_once '../classes/user.php';

class UserModel {
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
            self::$instance = new UserModel('mysql:host=localhost;dbname=db_users', 'root', '');
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

    public function getUsers() {

        $data = $this->getData();
        $userList = [];
        
        foreach ($data as $item) {
            $userList[] = $item['UserName'];
        }
    
        return $userList;
        }

    public function getUserById($userId) {
        if ($this->conn) {
            try {
                $stmt = $this->conn->prepare("SELECT UserName, Email, Password FROM users WHERE UserID = :userId");
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($result) {
                    // Create and return a User object
                    return new User(
                        $result['UserName'],
                        $result['Email'],
                        $result['Password']
                    );
                } else {
                    return null;
                }
            } catch (PDOException $e) {
                error_log("Query failed: " . $e->getMessage());
                return null;
            }
        } else {
            error_log("No connection.");
            return null;
        }
    }

    public function deleteUser($userId) {
        if ($this->conn) {
            try {
                $stmt = $this->conn->prepare("DELETE FROM users WHERE UserID = :userId");
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("Delete failed: " . $e->getMessage());
                return false;
            }
        } else {
            error_log("No connection.");
            return false;
        }
    }

    public function updateUser($userId, $userName, $email, $password) {
        if ($this->conn) {
            try {
                $stmt = $this->conn->prepare("
                    UPDATE users 
                    SET UserName = :userName, Email = :email, Password = :password
                    WHERE UserID = :userId
                ");
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("Update failed: " . $e->getMessage());
                return false;
            }
        } else {
            error_log("No connection.");
            return false;
        }
    }
}
?>