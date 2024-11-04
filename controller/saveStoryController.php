<?php
require_once '../logger/Logger.php';

class SaveStoryController {
    private $logger;

    public function __construct() {
        session_start();
        try {
            $this->logger = Logger::getInstance();
        } catch (Exception $e) {
            echo "Logger error: " . $e->getMessage();
        }
    }

    public function saveStoryProgress() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ../view/login.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['saveStory'])) {
                $userId = $_SESSION['user_id'];
                $storyPage = htmlspecialchars(trim($_POST['saveStory']));

                // Call the API to save story progress
                $apiUrl = 'http://localhost/UserManagement/controller/saveStory.php';
                $postData = http_build_query(['userId' => $userId, 'storyPage' => $storyPage]);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $apiUrl);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $apiResponse = curl_exec($ch);

            if (curl_errno($ch)) {
                $this->logger->log("CURL error: " . curl_error($ch));
                header('Location: ../view/error.php');
                exit();
            }

            curl_close($ch);

            // Log the raw API response for debugging
            $this->logger->log("API response: " . $apiResponse);

            $data = json_decode($apiResponse, true);
            if (isset($data['success']) && $data['success']) {
                $this->logger->log("User $userId story progress saved at page: $storyPage");
                header('Location: ../view/story.php');
                exit();
            } else {
                $errorMessage = isset($data['message']) ? $data['message'] : 'Unknown error';
                $this->logger->log("Failed to save story progress for user $userId. Error: " . $errorMessage);
                header('Location: ../view/story.php?error=' . urlencode($errorMessage));
                exit();
            }
            } else {
                $this->logger->log("No story page provided in the POST request.");
                header('Location: ../view/story.php');
                exit();
            }
        } else {
            $this->logger->log("Invalid request method for saveStoryController.");
            header('Location: ../view/error.php');
            exit();
        }
    }
}
?>