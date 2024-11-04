<?php
require_once '../logger/Logger.php';

session_start();
$logger = Logger::getInstance();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit();
}

$userId = $_SESSION['user_id'];

// API URL for fetching the story page
$apiUrl = 'http://localhost/UserManagement/controller/getStoryPage.php';
$postData = http_build_query(['userId' => $userId]);

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$apiResponse = curl_exec($ch);

if (curl_errno($ch)) {
    $logger->log("CURL error: " . curl_error($ch));
    header('Location: ../view/error.php');
    exit();
}

curl_close($ch);

$data = json_decode($apiResponse, true);

// Check for a valid response from the API
if ($data['success'] && isset($data['page'])) {
    $pageString = $data['page'];
    $filePath = '../story/' . $pageString . '.php';

    if (file_exists($filePath)) {
        header('Location: ' . $filePath);
        exit();
    } else {
        $logger->log("Story page file not found: " . $filePath);
        header('Location: ../story/outside.php');
        exit();
    }
} else {
    $logger->log("Failed to fetch story page for user $userId: " . $data['message']);
    header('Location: ../story/outside.php');
    exit();
}
?>