<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Employee') {
    header("Location: login_kanha.php");
    exit();
}
$animal = null;
if (isset($_GET['id'])) {
    $animal_id = $_GET['id'];
    $query = "SELECT Name, Status, Health_Condition FROM animals WHERE Animal_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $animal_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $animal = $result->fetch_assoc();
    if (!$animal) {
        echo "Animal not found.";
        exit();
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $health_condition = $_POST['health_condition'];
    $update_query = "UPDATE animals SET Health_Condition = ? WHERE Animal_ID = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $health_condition, $animal_id);
    if ($stmt->execute()) {
        echo "<script>alert('Updated Successfully!'); window.location.href='update_animal_kanha.php?id=$animal_id';</script>";
    } else {
        echo "<script>alert('Error updating record!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Animal - Kanha</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            overflow-x: hidden; 
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color:#014323;
            padding: 10px 20px;
            color: white;
            height: 70px;
        }
        .navbar img {
            height: 170px;
            cursor: pointer;
        }
        .logout-btn {
            background-color:rgb(128, 77, 0);
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            margin-right: 50px;
        }
        .logout-btn:hover {
            background-color:rgb(48, 35, 4);
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            flex: 1;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(4, 42, 1, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        select, button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            font-size: 16px;
        }
        button {
            background-color:rgb(128, 77, 0);
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color:rgb(1, 24, 10);
        }
        .footer {
            background-color: #014323;
            color: white;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            position: absolute;
             bottom: 0;
            }
    </style>
    <script>
        function confirmUpdate() {
            return confirm("Are you sure you want to update the health condition?");
        }
    </script>
</head>
<body>
    <div class="navbar">
        <a href="employee_kanha.php">
            <img src="logo.png" alt="Logo">
        </a>
        <form action="logout.php" method="POST">
            <button class="logout-btn" type="submit">Logout</button>
        </form>
    </div>\
    <div class="container">
        <h2>Update Animal - Kanha National Park</h2>
        <?php if ($animal): ?>
            <p><strong>Animal Name:</strong> <?= htmlspecialchars($animal['Name']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($animal['Status']) ?></p>
            <form method="POST" onsubmit="return confirmUpdate();">
                <label>Health Condition:</label><br><br>
                <select name="health_condition">
                <option value="Good" <?= ($animal['Health_Condition'] == 'Good') ? 'selected' : '' ?>>Good</option><br><br>
                    <option value="Critical" <?= ($animal['Health_Condition'] == 'Critical') ? 'selected' : '' ?>>Critical</option><br><br>
                    <option value="Recovering" <?= ($animal['Health_Condition'] == 'Recovering') ? 'selected' : '' ?>>Recovering</option><br><br>
                </select><br><br><br><br><br><br>
                <button type="submit">Update</button>
            </form>
        <?php else: ?>
            <p>Invalid animal ID.</p>
        <?php endif; ?>
    </div><br><br><br><br><br>
    <div class="footer">
        <p>&copy; 2025 Kanha National Park</p>
    </div>
</body>
</html>