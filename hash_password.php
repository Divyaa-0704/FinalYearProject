<?php
// Database connection using PDO
require_once __DIR__ . '/db_connect.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch only users of park_id = 2 whose passwords need hashing
$sql = "SELECT user_id, password FROM users WHERE park_id = 2";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare update statement
$updateSQL = "UPDATE users SET password = :password WHERE user_id = :user_id";
$updateStmt = $pdo->prepare($updateSQL);

foreach ($users as $user) {
    $currentPassword = $user['password'];
    
    // Skip already hashed passwords (assuming they use bcrypt)
    if (!password_needs_rehash($currentPassword, PASSWORD_DEFAULT) && strlen($currentPassword) === 60) {
        continue;
    }

    // Hash the plaintext password
    $hashedPassword = password_hash($currentPassword, PASSWORD_DEFAULT);
    
    // Update the database with the hashed password
    $updateStmt->execute([
        ':password' => $hashedPassword,
        ':user_id' => $user['user_id']
    ]);

    echo "Updated password for user ID " . $user['user_id'] . "<br>";
}

echo "All plaintext passwords for park_id = 2 have been securely hashed!";
?>
