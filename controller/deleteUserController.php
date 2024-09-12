<?php
require_once '../model/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['UserID'])) {
    $userID = $_POST['UserID'];
    $model = UserModel::getInstance();

    $model->deleteUser($userID);

    header('Location: ../view/userList.php');
    exit();
} else {
    // Handle invalid request
    echo "Invalid request";
}
?>