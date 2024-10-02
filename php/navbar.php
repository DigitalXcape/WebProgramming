<?php

session_start(); // Start the session to access session variables

// DO NOT FORGET THE BOOTSTRAP LINK

// Define an array of navigation items
$navItems = [
    'Home' => '../view/index.php',
    'Library Test' => '../view/libraryTest.php',
    'User List' => '../view/userList.php',
    'Create New User' => '../view/newUserForm.php',
    'Story Game' => '../view/story.php'
];

// Function to generate the navigation bar with Bootstrap classes
function generateNavBar($items) {
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">';
    echo '<div class="container-fluid">';
    echo '<div class="collapse navbar-collapse">';
    
    // Left-aligned navigation items
    echo '<ul class="navbar-nav me-auto">';
    foreach ($items as $name => $url) {
        echo "<li class='nav-item'><a class='nav-link' href='$url'>$name</a></li>";
    }
    echo '</ul>';

    // Right-aligned user information (if logged in)
    if (isset($_SESSION['username'])) {
        // Display the username with a dropdown
        $username = htmlspecialchars($_SESSION['username']);
        echo '<ul class="navbar-nav ms-auto">';
        echo "<li class='nav-item dropdown'>";
        echo "<a class='nav-link dropdown-toggle' href='#' id='userDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'>$username</a>";
        echo '<ul class="dropdown-menu" aria-labelledby="userDropdown">';
        echo '<li><a class="dropdown-item" href="../controller/logoutController.php">Logout</a></li>'; // Logout link to logoutController.php
        echo '</ul>';
        echo '</li>';
        echo '</ul>';
    } else {
        // If no user is logged in, display the login option
        echo '<ul class="navbar-nav ms-auto">';
        echo "<li class='nav-item'><a class='nav-link' href='../view/login.php'>Log In</a></li>";
        echo '</ul>';
    }

    echo '</div>'; // Close collapse div
    echo '</div>'; // Close container-fluid div
    echo '</nav>';
}
?>