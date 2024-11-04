<?php
require_once '../logger/Logger.php';

class UserController {
    private $logger;

    public function __construct() {
        try {
            $this->logger = Logger::getInstance();
        } catch (Exception $e) {
            echo "Logger error: " . $e->getMessage();
        }
    }

    // Retrieve the list of users from the API
    public function getUsers() {
        $apiUrl = 'http://localhost/UserManagement/controller/getUsers.php';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $apiResponse = curl_exec($ch);

        if (curl_errno($ch)) {
            $this->logger->log("CURL error: " . curl_error($ch));
            return [];
        }

        curl_close($ch);

        $data = json_decode($apiResponse, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->logger->log("JSON decode error: " . json_last_error_msg());
            return [];
        }

        return $data['success'] ? $data['users'] : [];
    }

    // Delete a user by sending a request to the deleteUser API endpoint
    public function deleteUser($userId) {
        $apiUrl = 'http://localhost/UserManagement/controller/deleteUser.php';

        $postData = http_build_query(['userId' => $userId]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $apiResponse = curl_exec($ch);

        if (curl_errno($ch)) {
            $this->logger->log("CURL error: " . curl_error($ch));
            return false;
        }

        curl_close($ch);

        $data = json_decode($apiResponse, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->logger->log("JSON decode error: " . json_last_error_msg());
            return false;
        }

        return $data['success'];
    }
}
?>