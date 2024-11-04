<?php
session_start();

function checkUserRole($requiredRole) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $requiredRole) {
        header('Location: ../view/access_denied.php');
        exit;
    }
}
?>