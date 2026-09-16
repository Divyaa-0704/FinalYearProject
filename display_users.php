<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <style>
        img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php
session_start();

// Initialize variables
$username = "";
$email = "";
$errors = array(); 

// Connect to the database
require_once __DIR__ . '/db_connect.php';

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Fetch user data
$sql = "SELECT id, username, email, img FROM users";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<p><strong>ID:</strong> " . htmlspecialchars($row["id"]) . "</p>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($row["username"]) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($row["email"]) . "</p>";
        
        // Display image if available
        if (!empty($row["img"])) {
            echo "<img src='" . htmlspecialchars($row["img"]) . "' alt='User Image'>";
        } else {
            echo "<p>No image available</p>";
        }

        echo "<hr>";
        echo "</div>";
    }
} else {
    echo "<p>No results found</p>";
}

// Close connection
$db->close();
?> 

</body>
</html>
