<?php
require_once '../logger/Logger.php';
define('LOGIN_API_URL', 'http://localhost/UserManagementAPI/controller/login.php');

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
    
        // Send a request to the external login controller
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, LOGIN_API_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['email' => $email, 'password' => $password]));
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
        
        $data = json_decode($apiResponse, true);
        
        // Log JSON decode errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            $logger->log("JSON decode error: " . json_last_error_msg());
        }
    
        // Check if login was successful
        if ($data['success']) {
            // Store user data in session, including the role
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