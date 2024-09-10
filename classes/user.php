<?php
class User {
    // Properties (private fields)
    private $username;
    private $email;
    private $password;

    // Constructor to initialize the object
    public function __construct($username, $email, $password) {
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    // Getter for username
    public function getUsername() {
        return $this->username;
    }

    // Setter for username
    public function setUsername($username) {
        // You can add validation for username here
        if (!empty($username)) {
            $this->username = $username;
        } else {
            throw new Exception("Username cannot be empty.");
        }
    }

    // Getter for email
    public function getEmail() {
        return $this->email;
    }

    // Setter for email
    public function setEmail($email) {
        // Basic email validation
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            throw new Exception("Invalid email format.");
        }
    }

    // Getter for password (Note: typically, you shouldn't have a getter for passwords)
    public function getPassword() {
        return $this->password;
    }

    // Setter for password
    public function setPassword($password) {
        // You can add password strength validation here
        if (strlen($password) >= 6) {
            $this->password = password_hash($password, PASSWORD_BCRYPT); // Hashing the password
        } else {
            throw new Exception("Password must be at least 6 characters long.");
        }
    }

    // Method to display user info (for testing purposes)
    public function displayUserInfo() {
        echo "Username: " . $this->getUsername() . "<br>";
        echo "Email: " . $this->getEmail() . "<br>";
    }
}
?>