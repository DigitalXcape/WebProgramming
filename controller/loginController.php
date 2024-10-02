<?php
require_once '../autoLoader.php';
require_once '../classes/user.php';
require_once '../logger/Logger.php';

$logger = Logger::getInstance();

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $model = UserModel::getInstance();
        $user = $model->getUserByEmail($email);

        if ($user && $password === $user->getPassword()) {
            $_SESSION['username'] = $user->getUserName();
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['user_id'] = $user->getId();
            
            header('Location: ../view/index.php');
            exit();
        } else {
            $logger->log("Invalid email or password");
            header('Location: ../view/login.php');
            exit();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

header('Location: ../view/index.php');
exit();
?>