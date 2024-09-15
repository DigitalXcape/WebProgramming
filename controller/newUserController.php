<?php
require_once '../model/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_POST['userId'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $model = UserModel::getInstance();

        $success = $model->addUser($username, $email, $password);

        if ($success) {
            echo "User created successfully!";

        } else {
            echo "Failed to create user.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    header('Location: ../view/userList.php');
    exit();
}
?>