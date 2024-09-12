<?php
require_once '../model/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_POST['userId'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $model = UserModel::getInstance();

        $success = $model->updateUser($userID, $username, $email, $password);

        if ($success) {
            echo "User updated successfully!";

        } else {
            echo "Failed to update user.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    header('Location: ../view/userList.php');
    exit();
}
?>