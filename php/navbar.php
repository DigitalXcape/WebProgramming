<?php

//DO NOT FORGET THE BOOSTRAP LINK

// Define an array of navigation items
$navItems = [
    'Home' => '../view/index.php',
    'Library Test' => '../view/libraryTest.php',
    'User List' => '../view/userList.php'    
];

// Function to generate the navigation bar with Bootstrap classes
function generateNavBar($items) {
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">';
    echo '<ul class="navbar-nav mr-auto">';
    foreach ($items as $name => $url) {
        echo "<li class='nav-item'><a class='nav-link' href='$url'>$name</a></li>";
    }
    echo '</ul></nav>';
}
?>