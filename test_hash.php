<?php
$password = "test123"; // Sample password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

if ($hashedPassword) {
    echo "Hashed password: " . $hashedPassword;
} else {
    echo "Error hashing password.";
}
?>
