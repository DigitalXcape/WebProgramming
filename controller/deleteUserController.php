<?php
session_start();
require_once '../logger/Logger.php';

// Define the API endpoint for deleting a user
define('DELETE_USER_API_URL', 'http://localhost/UserManagementAPI/controller/deleteUser.php');

$responseMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $logger = Logger::getInstance();
    } catch (Exception $e) {
        echo "Logger error: " . $e->getMessage();
    }

    $userId = $_POST['userId']; // Retrieve the user ID to delete

    try {
        // Log the user deletion attempt
        $logger->log("Attempting to delete user with ID: $userId");

        // Prepare the data for the API request
        $postData = http_build_query(['userId' => $userId]);

        // Set up the cURL request to the API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, DELETE_USER_API_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request
        $apiResponse = curl_exec($ch);

        // Log any CURL errors
        if (curl_errno($ch)) {
            $logger->log("CURL error: " . curl_error($ch));
        }

        curl_close($ch);

        // Decode the JSON response from the API
        $data = json_decode($apiResponse, true);

        // Log JSON decode errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            $logger->log("JSON decode error: " . json_last_error_msg());
        }

        // Handle API response
        if ($data['success']) {
            $responseMessage = "User deleted successfully!";
            $logger->log("User deleted successfully with ID: $userId");
        } else {
            $responseMessage = $data['message'];
            $logger->log("Failed to delete user with ID: $userId - Message: " . $data['message']);
        }
    } catch (Exception $e) {
        $logger->log("Exception caught: " . $e->getMessage());
        $responseMessage = 'An unexpected error occurred.';
    }
}

// Display the response message or pass it to the view
$_SESSION['responseMessage'] = $responseMessage;
header('Location: ../view/userList.php');
exit();
?>