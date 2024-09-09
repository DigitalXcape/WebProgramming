<?php
// Define an array of navigation items
$navItems = [
    'Home' => 'index.php',
    'Create User' => 'view/userForm.php',
];

// Function to generate the navigation bar
function generateNavBar($items) {
    echo '<nav><ul>';
    foreach ($items as $name => $url) {
        echo "<li><a href='$url'>$name</a></li>";
    }
    echo '</ul></nav>';
}
?>