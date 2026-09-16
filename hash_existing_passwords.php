<?php
// Database connection
require_once __DIR__ . '/db_connect.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch users with plaintext passwords
$sql = "SELECT user_id, password FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare update statement
$updateSQL = "UPDATE users SET password = :password WHERE user_id = :user_id";
$updateStmt = $pdo->prepare($updateSQL);

foreach ($users as $user) {
    // Skip already hashed passwords
    if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
        $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
        
        // Update password in database
        $updateStmt->execute([
            ':password' => $hashedPassword,
            ':user_id' => $user['user_id']
        ]);
        
        echo "Updated password for user ID " . $user['user_id'] . "<br>";
    }
}

echo "All plaintext passwords have been hashed!";
?>
