<?php
require_once '../logger/Logger.php';
define('USER_MANAGEMENT_API_URL', 'http://localhost/UserManagementAPI/service/userManagementService.php');

// Start a session to manage user data if needed
session_start();

$response = [
    'success' => false,
    'message' => 'Invalid email or password',
    'token' => null
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $logger = Logger::getInstance();
    } catch (Exception $e) {
        echo "Logger error: " . $e->getMessage();
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Log the beginning of the login attempt
        $logger->log("Attempting to log in with email: $email");

        // Prepare the data to send to the API
        $postData = json_encode([
            'email' => $email,
            'password' => $password
        ]);

        // Send a request to the user management API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, USER_MANAGEMENT_API_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // Set content type to JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Execute the request
        $apiResponse = curl_exec($ch);
        
        // Log any CURL errors
        if (curl_errno($ch)) {
            $logger->log("CURL error: " . curl_error($ch));
        }

        curl_close($ch);

        // Log the raw API response
        $logger->log("API Response: " . $apiResponse);

        // Decode the JSON response
        $data = json_decode($apiResponse, true);

        // Log JSON decode errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            $logger->log("JSON decode error: " . json_last_error_msg());
        }

        // Check if login was successful
        if (isset($data['success']) && $data['success']) {
            // Store user data in session
            $_SESSION['token'] = $data['token'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['user_id'] = $data['user_id'];
            $_SESSION['role'] = $data['role'];
            $logger->log("Login successful for email: $email");
            header('Location: ../view/index.php'); // Redirect on successful login
            exit;
        } else {
            $logger->log("Login failed for email: $email - Message: " . $data['message']);
            header('Location: ../view/login.php?error=' . urlencode($data['message'])); // Redirect with error message
            exit;
        }
    } catch (Exception $e) {
        $logger->log("Exception caught: " . $e->getMessage());
        header('Location: ../view/login.php?error=' . urlencode('An unexpected error occurred.'));
        exit;
    }
}

// Pass response data back to the view if needed
if (!empty($response['message'])) {
    echo json_encode($response);
}
?>