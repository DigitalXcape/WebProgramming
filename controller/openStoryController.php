<?php
require_once '../autoLoader.php';
require_once '../classes/user.php';
require_once '../logger/Logger.php';

$logger = Logger::getInstance();
session_start();

$model = UserModel::getInstance();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit();
}

$pageString = $model->getStoryPageById($_SESSION['user_id']);

$filePath = '../story/' . $pageString . '.php';
if (!file_exists($filePath)) {
    header('Location: ../story/outside.php');
    exit();
}
header('Location: ' . $filePath);
exit();
?>