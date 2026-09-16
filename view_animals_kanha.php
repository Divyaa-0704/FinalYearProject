<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Employee') {
    header("Location: login_kanha.php");
    exit();
}
$park_id = 1; 
$query = "SELECT * FROM animals WHERE park_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $park_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Records - Kanha</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #eef0e5; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #2d4a32; 
            padding: 15px;
            height: 90px;
        }
        .navbar img {
            height: 170px;
            cursor: pointer;
        }
        .logout-btn {
            background-color:rgb(0, 27, 13); /* Deep muted red */
            color: white;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .logout-btn:hover {
            background-color: #922b21; /* Slightly darker red */
        }
        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            flex-grow: 1;
        }
        h2 {
            text-align: center;
            color: #1e3d2f; 
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: #f8f9f5;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #3a5d40; 
            color: white;
        }
        tr:nth-child(even) {
            background-color: #dde5d4; 
        }
        a.edit-link {
            text-decoration: none;
            color: #245129; 
            font-weight: bold;
            transition: color 0.3s;
        }
        a.edit-link:hover {
            color: #183b23; 
        }
        .footer {
            background-color: #2d4a32; 
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="dashboard_kanha.php">
            <img src="logo.png" alt="Logo">
        </a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div><br>
    <div class="container">
        <h2>Animal Records - Kanha National Park</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Species</th>
                <th>Status</th>
                <th>Health Condition</th>
                <th>Update</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['Name'] ?></td>
                <td><?= $row['Species'] ?></td>
                <td><?= $row['Status'] ?></td>
                <td><?= $row['Health_Condition'] ?></td>
                <td>
                    <a href="update_animal_kanha.php?id=<?= $row['Animal_ID'] ?>" class="edit-link">Edit</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div><br>
    <div class="footer">
        <p>&copy; 2025 Kanha National Park</p>
    </div>
</body>
</html>
