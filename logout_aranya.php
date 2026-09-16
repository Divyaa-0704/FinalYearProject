<?php
session_start();
$_SESSION = array();  // Clear all session variables
session_unset();  // Unset session variables
session_destroy(); // Destroy the session
header("Location: login_aranya.php"); // Ensure correct redirection
exit();
?>
