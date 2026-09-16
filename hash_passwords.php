<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/db_connect.php';

// Select all users from the database
$sql = "SELECT user_id, password FROM users";  // Replace 'user_id' with the actual primary key column name
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Fetch all users
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the SQL update query
$updateSQL = "UPDATE users SET password = :password WHERE user_id = :user_id";  // Adjust column name here
$updateStmt = $pdo->prepare($updateSQL);

// Loop through users and update password with the hashed version
foreach ($users as $user) {
    // Hash the password
    $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);

    // Bind the parameters and execute the update query
    $updateStmt->bindParam(':password', $hashedPassword);
    $updateStmt->bindParam(':user_id', $user['user_id']);  // Adjust column name here
    
    try {
        $updateStmt->execute();
        echo "Password for user with ID " . $user['user_id'] . " updated successfully!<br>";
    } catch (PDOException $e) {
        echo "Error updating password for user with ID " . $user['user_id'] . ": " . $e->getMessage() . "<br>";
    }
}

?>
