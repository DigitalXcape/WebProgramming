<?php
session_start();
require_once '../logger/Logger.php';

define('EDIT_USER_API_URL', 'http://localhost/UserManagementAPI/service/userManagementService.php'); // Update to the service URL

$responseMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $logger = Logger::getInstance();
    } catch (Exception $e) {
        echo "Logger error: " . $e->getMessage();
    }

    // Ensure all required parameters are provided
    if (isset($_POST['userId'], $_POST['username'], $_POST['email'], $_POST['password'])) {
        $userId = $_POST['userId'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            // Log the user update attempt
            $logger->log("Attempting to update user with ID: $userId");

            // Prepare the data for the API request
            $putData = json_encode([
                'userId' => $userId,
                'username' => $username,
                'email' => $email,
                'password' => $password
            ]);

            // Set up the cURL request to the API
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, EDIT_USER_API_URL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Use PUT method
            curl_setopt($ch, CURLOPT_POSTFIELDS, $putData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($putData)
            ]);

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
                $responseMessage = "User updated successfully!";
                $logger->log("User updated successfully with ID: $userId");
            } else {
                $responseMessage = $data['message'];
                $logger->log("Failed to update user with ID: $userId - Message: " . $data['message']);
            }
        } catch (Exception $e) {
            $logger->log("Exception caught: " . $e->getMessage());
            $responseMessage = 'An unexpected error occurred.';
        }
    } else {
        $responseMessage = 'All fields are required for updating user.';
        $logger->log("Incomplete data provided for user update.");
    }
}

// Store response message in session and redirect
$_SESSION['responseMessage'] = $responseMessage;
header('Location: ../view/userList.php');
exit();
?>