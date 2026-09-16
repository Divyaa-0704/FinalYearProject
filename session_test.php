<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== "Super User") {
    header("Location: login_kanha.php");
    exit();
}

echo "Session User: " . $_SESSION['username']; // Debugging Output
?>
