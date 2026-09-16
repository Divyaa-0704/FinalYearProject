<?php
session_start();
ob_start(); // Prevent header issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/db_connect.php';

// Function to log errors (for debugging)
function logMessage($message) {
    file_put_contents("debug_log.txt", date("Y-m-d H:i:s") . " - " . $message . "\n", FILE_APPEND);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Check if user is Admin or Employee with park_id = 2
        $stmt = $conn->prepare("SELECT user_id, password, role, park_id FROM users WHERE username = ? AND park_id = 2");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) { 
            // User found in `users` table
            $stmt->bind_result($user_id, $hashed_password, $role, $park_id);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                $_SESSION['park_id'] = 2; // Ensure park_id = 2 is set

                logMessage("Login successful for user: $username (Role: $role, Park ID: 2)");

                // Redirect based on role
                if ($role === 'Admin') {
                    header("Location: dashboard_admin_aranya.php");
                } elseif ($role === 'Employee') {
                    header("Location: employee_aranya.php");
                } else {
                    $_SESSION['error'] = "Invalid role!";
                    logMessage("Invalid role detected for user: $username");
                    header("Location: login_aranya.php");
                }
                $stmt->close();
                exit();
            } else {
                $_SESSION['error'] = "Incorrect password!";
                logMessage("Incorrect password attempt for user: $username");
            }
        } else {
            $stmt->close(); // Close before new query

            // Check if user is a Visitor
            $stmt = $conn->prepare("SELECT password FROM visitors WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($hashed_password);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $username; // No `id` available, use username
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = "Visitor"; // Hardcoded role
                    $_SESSION['park_id'] = 2; // Ensure Visitors have park_id = 2

                    logMessage("Login successful for visitor: $username (Assigned park_id = 2)");

                    header("Location: home_aranya.html");
                    $stmt->close();
                    exit();
                } else {
                    $_SESSION['error'] = "Incorrect password!";
                    logMessage("Incorrect password attempt for visitor: $username");
                }
            } else {
                $_SESSION['error'] = "User not found!";
                logMessage("Failed login attempt: User not found ($username)");
            }
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Username and password are required!";
        logMessage("Login failed: Missing credentials");
    }
    header("Location: login_aranya.php");
    exit();
}

$conn->close();
ob_end_flush();
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-image: url('img1.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      min-height: 100vh;
      display: flex;
      justify-content: flex-end;
      align-items: center;
      padding-right: 10%;
    }
    .login-container {
      width: 100%;
      max-width: 400px;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      border-radius: 12px;
      padding: 24px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }
    .btn-brown {
      background-color: #654321;
      transition: background 0.3s ease;
    }
    .btn-brown:hover {
      background-color: #50351d;
    }
    .text-brown {
      color: #654321;
    }
    .error {
      color: red;
      font-size: 14px;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2 class="text-3xl font-bold text-center text-white mb-6">Login</h2>
    <?php 
    if (!empty($_SESSION['error'])) { 
    ?>
      <p class="error"><?php echo $_SESSION['error']; ?></p>
    <?php 
      unset($_SESSION['error']); 
    } 
    ?>
    <form method="post" action="login_aranya.php" class="space-y-5">
      <div>
        <label class="block text-lg font-medium text-white">Username</label>
        <input type="text" name="username" required class="w-full px-4 py-3 text-lg border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-transparent text-white placeholder-gray-300">
      </div>
      <div>
        <label class="block text-lg font-medium text-white">Password</label>
        <input type="password" name="password" required class="w-full px-4 py-3 text-lg border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-transparent text-white placeholder-gray-300">
        <a href="forgot_password_aranya.php" class="text-lg text-brown hover:underline float-right mt-2">Forgot password?</a>
      </div>
      <button type="submit" class="w-full text-white text-lg font-semibold py-3 rounded-lg btn-brown">Sign In</button>
      <p class="text-center text-lg text-white mt-4">
        Not a member yet? <a href="register_aranya.php" class="text-brown hover:underline">Sign up</a>
      </p>
    </form>
  </div>
</body>
</html>
