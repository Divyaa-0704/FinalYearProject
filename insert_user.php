<?php
// Database connection
require_once __DIR__ . '/db_connect.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Sample user data
$name = "John Doe";
$username = "johndoe";
$password = "password123";  // Plain text password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash password
$email = "johndoe@example.com";
$phone = "9876543210";

// Insert query
$sql = "INSERT INTO users (name, username, password, email, phone) VALUES (:name, :username, :password, :email, :phone)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':name' => $name,
    ':username' => $username,
    ':password' => $hashedPassword,
    ':email' => $email,
    ':phone' => $phone
]);

echo "User added successfully with hashed password!";
?>
