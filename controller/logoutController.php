<?php
session_start();
session_destroy(); // Destroy the session
header('Location: ../view/login.php'); // Redirect to login page after logout
exit();
?>