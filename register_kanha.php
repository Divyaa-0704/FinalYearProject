<?php
// Start session
session_start();

require_once __DIR__ . '/db_connect.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password
    $park_id = 1; 


    // Insert into database
    $sql = "INSERT INTO visitors (email, username, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $username, $password);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful! 🎉');
                window.location.href = 'home_kanha.html';
              </script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Close DB connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="overflow-x-hidden font-sans">
    <div class="relative w-full h-screen">
        <img src="img1.jpg" class="absolute inset-0 w-full h-full object-cover" alt="Background Image">
        <div class="absolute top-1/2 left-3/4 transform -translate-x-1/2 -translate-y-1/2 bg-white bg-opacity-20 backdrop-blur-lg p-8 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-bold text-center mb-4">Register</h2>
            <form action="register_kanha.php" method="POST" class="space-y-4">
                <div>
                    <label for="email" class="block font-semibold">Email:</label>
                    <input type="email" name="email" class="w-full px-4 py-2 border rounded-md bg-white bg-opacity-40 focus:bg-opacity-100 transition" required>
                </div>
                <div>
                    <label for="username" class="block font-semibold">Username:</label>
                    <input type="text" name="username" class="w-full px-4 py-2 border rounded-md bg-white bg-opacity-40 focus:bg-opacity-100 transition" required>
                </div>
                <div>
                    <label for="password" class="block font-semibold">Password:</label>
                    <input type="password" name="password" class="w-full px-4 py-2 border rounded-md bg-white bg-opacity-40 focus:bg-opacity-100 transition" required>
                </div>
                <div>
                    <button type="submit" class="w-full bg-[#8B4513] text-white py-2 rounded-md font-bold">Register</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

