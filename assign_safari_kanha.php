<?php
session_start();
include 'db_connect.php'; 
$query = "SELECT * FROM bookings WHERE package = 'safari' AND park_id = 1 AND safari_vehicle IS NULL ORDER BY datetime ASC";
$result = $conn->query($query);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_vehicle'])) {
    $booking_id = $_POST['booking_id'];
    $vehicle = $_POST['safari_vehicle'];
    $updateQuery = "UPDATE bookings SET safari_vehicle = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $vehicle, $booking_id);
    if ($stmt->execute()) {
        echo "<script>alert('Vehicle assigned successfully!'); window.location.href='assign_safari_kanha.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error assigning vehicle.');</script>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Safari Vehicles</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F4E1D2;
            color: #5A3E2B;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #8B5E3B;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            height: 70px;
        }
        .navbar img {
            height: 170px;
            cursor: pointer;
        }
        .logout-btn {
            background-color: #5A3E2B;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            margin-right: 80px;
        }
        .container {
            width: 80%;
            margin: auto;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
            margin-top: 20px;
            background: white;
        }
        th, td {
            border: 1px solid #5A3E2B;
            padding: 15px;
            text-align: center;
        }
        th {
            background-color: #8B5E3B;
            color: white;
        }
        .footer {
            background-color: #8B5E3B;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="employee_kanha.php"><img src="logo.png" alt="Kanha National Park"></a>
        <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
    </div>
    <div class="container">
        <h2>Assign Safari Vehicles</h2>
        <?php if ($result->num_rows > 0) { ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Tickets</th>
                    <th>Datetime</th>
                    <th>Assign Vehicle</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']); ?></td>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['phone']); ?></td>
                        <td><?= htmlspecialchars($row['tickets']); ?></td>
                        <td><?= htmlspecialchars($row['datetime']); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="booking_id" value="<?= $row['id']; ?>">
                                <select name="safari_vehicle" required>
                                    <option value="">Select Vehicle</option>
                                    <option value="Jeep 1">Jeep 1</option>
                                    <option value="Jeep 2">Jeep 2</option>
                                    <option value="Jeep 3">Jeep 3</option>
                                </select>
                                <button type="submit" name="assign_vehicle">Assign</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No pending safari bookings to assign.</p>
        <?php } ?>
    </div>
    <div class="footer">
        &copy; 2025 Kanha National Park - All Rights Reserved
    </div>
</body>
</html>