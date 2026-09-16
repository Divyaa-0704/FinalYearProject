<?php 
session_start();

// Connect to database
require_once __DIR__ . '/db_connect.php';

$errors = array();

// REGISTER USER
if (isset($_POST['reg_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    // Validate form inputs
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 !== $password_2) { array_push($errors, "Passwords do not match"); }

    // Check if user exists
    $check_user = "SELECT * FROM users WHERE Username='$username' OR Email='$email' LIMIT 1";
    $result = mysqli_query($db, $check_user);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['Username'] === $username) { array_push($errors, "Username already exists"); }
        if ($user['Email'] === $email) { array_push($errors, "Email already exists"); }
    }

    // Register user if no errors
    if (count($errors) == 0) {
        $hashed_password = password_hash($password_1, PASSWORD_DEFAULT);
        $role = "Visitor";  // Default role is Visitor

        $query = "INSERT INTO users (Username, Email, Password, Role) VALUES ('$username', '$email', '$hashed_password', '$role')";
        mysqli_query($db, $query);

        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header('location: visitor_dashboard.php'); // Redirect new visitors
    }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($password)) { array_push($errors, "Password is required"); }

    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE Username='$username' LIMIT 1";
        $result = mysqli_query($db, $query);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['Password'])) {
            $_SESSION['username'] = $user['Username'];
            $_SESSION['role'] = $user['Role'];

            // Redirect based on role
            switch ($user['Role']) {
                case 'Super User':
                    header('location: superuser.php');
                    break;
                case 'Admin':
                    header('location: admin.php');
                    break;
                case 'Employee':
                    header('location: employee.php');
                    break;
                case 'Visitor':
                    header('location: visitor.php');
                    break;
                default:
                    header('location: visitor.php'); // Default to visitor
                    break;
            }
        } else {
            echo "<script>alert('Wrong username or password');</script>";
        }
    }
}
?>
