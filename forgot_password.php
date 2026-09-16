<?php 
session_start();
require_once __DIR__ . '/db_connect.php';

$errors = array();

if (isset($_POST['reset_password'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $new_password = mysqli_real_escape_string($db, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($db, $_POST['confirm_password']);

    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($new_password)) { array_push($errors, "New password is required"); }
    if ($new_password !== $confirm_password) { array_push($errors, "Passwords do not match"); }

    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE Email='$email' LIMIT 1";
        $result = mysqli_query($db, $query);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET Password='$hashed_password' WHERE Email='$email'";
            mysqli_query($db, $update_query);

            echo "<script>alert('Password reset successful! You can now login with your new password.'); window.location='login_kanha.php';</script>";
        } else {
            echo "<script>alert('Error: Email not found!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFF8E7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            width: 350px;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 22px;
            margin-bottom: 15px;
        }
        img {
            width: 120px; /* Increased image size */
            margin-bottom: 15px;
        }
        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
            display: block;
            margin: 0 auto;
        }
      .btn {
    width: 100%;
    padding: 12px;
    background-color:rgb(112, 52, 3); /* Dark brown */
    border: none;
    border-radius: 5px;
    font-size: 16px;
    color: white;
    cursor: pointer;
    transition: 0.3s;
}

.btn:hover {
    background-color: #4E342E; /* Slightly darker brown */
}

        .error {
            color: red;
            font-size: 12px;
            text-align: left;
            margin-top: -10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <img src="lock.png" alt="Forgot Password Image">
        <form method="post" action="forgot_password.php">
            <div class="input-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>
            <div class="input-group">
                <label>New Password</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="input-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn" name="reset_password">Reset Password</button>
        </form>
    </div>
</body>
</html>