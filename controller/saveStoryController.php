<?php
require_once '../autoLoader.php';
require_once '../logger/Logger.php';

class saveStoryController {
    private $logger;
    private $model;

    public function __construct() {
        session_start();
        $this->logger = Logger::getInstance();
        $this->model = UserModel::getInstance();
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

                // Update the StoryPage in the database
                $result = $this->model->updateStoryPageById($userId, $storyPage);

                if ($result) {
                    $this->logger->log("User " . $userId . " story progress saved at page: " . $storyPage);
                    header('Location: ../view/story.php');
                    exit();
                } else {
                    $this->logger->log("Failed to save story progress for user OR page data was the same: " . $userId);
                    header('Location: ../view/story.php');
                    exit();
                }
            } else {
                $this->logger->log("No story page provided in the POST request.");
                header('Location: ../story/outside.php');
                exit();
            }
        } else {
            $this->logger->log("Invalid request method for saveStoryController.");
            header('Location: ../view/error.php');
            exit();
        }
    }
}