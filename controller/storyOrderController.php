<?php

require_once '../logger/Logger.php';

class storyOrderController{
 
    private $logger;

    public function __construct() {
        $this->logger = Logger::getInstance();        
    }


    // Function to add a string to the array and save it in cookies
    function addToArrayAndOpen($string) {
        // Retrieve the array from the cookies if it exists, otherwise create an empty array
        $array = isset($_COOKIE['myArray']) ? json_decode($_COOKIE['myArray'], true) : [];

        // Add the new string to the array
        $array[] = $string;

        $this->logger->log(implode(", ", $array));

        // Save the updated array back to the cookies
        setcookie('myArray', json_encode($array), time() + 3600, "/");

        $filePath = '../story/' . $string . '.php';
            if (!file_exists($filePath)) {
                header('Location: ../story/outside.php');
                $this->clearCookies();
                exit();
            }
            header('Location: ' . $filePath);
    }

    // Function to remove the last string from the array and save it in cookies
    function removeLastFromArrayAndOpen() {
        // Retrieve the array from the cookies if it exists
        if (isset($_COOKIE['myArray'])) {
            $array = json_decode($_COOKIE['myArray'], true);

            // Remove the last element from the array if it's not empty
            if (!empty($array)) {
                array_pop($array);
                $pageString = $array[count($array) - 1];
            }

            // Save the updated array back to the cookies
            setcookie('myArray', json_encode($array), time() + 3600, "/");

            $filePath = '../story/' . $pageString . '.php';
            if (!file_exists($filePath)) {
                header('Location: ../story/outside.php');
                $this->clearCookies();
                exit();
            }
            header('Location: ' . $filePath);
        }
    }

    // Function to clear the cookies
    function clearCookies() {
        // Clear the specific cookie
        setcookie('myArray', '', time() - 3600, "/"); // Set expiration in the past to delete

        // Optional: Log the action
        $this->logger->log("Cookies cleared.");
    }
}
