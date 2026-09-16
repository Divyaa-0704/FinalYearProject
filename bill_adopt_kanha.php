<?php
require 'db_connect.php'; 
if (!isset($_GET['booking_id'])) {
    die("Invalid request. No booking ID provided.");
}
$booking_id = intval($_GET['booking_id']);
$query = "SELECT * FROM adopt_booking WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Booking not found.");
}
$booking = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Bill</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #8B5A2B, #CD853F);
        }
        .bill-container {
            background: #F5DEB3;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            width: 400px;
            text-align: center;
        }
        h1, h2 {
            color: #5A3825;
        }
        .details {
            text-align: left;
            margin-top: 15px;
        }
        .details p {
            font-size: 16px;
            margin: 8px 0;
        }
        .print-button, .home-button {
            background: #A0522D;
            color: white;
            border: none;
            padding: 12px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            transition: background 0.3s, transform 0.2s;
        }
        .print-button:hover, .home-button:hover {
            background: #8B4513;
            transform: scale(1.05);
        }
        .print-button:focus, .home-button:focus {
            outline: none;
        }
        .buttons-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
            width: 100%;
        }
        .buttons-container button {
            flex: 1;
            max-width: 180px; /* Ensure the buttons stay within a reasonable size */
        }
    </style>
</head>
<body>
    <div class="bill-container">
        <h1>Adoption Receipt</h1>
        <h2>Booking ID: <?php echo htmlspecialchars($booking['id']); ?></h2>
        <div class="details">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($booking['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($booking['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($booking['phone']); ?></p>
            <p><strong>Adopted Animal:</strong> <?php echo htmlspecialchars($booking['animal']); ?></p>
            <p><strong>Adoption Date:</strong> <?php echo htmlspecialchars($booking['adoption_date']); ?></p>
        </div>
        <div class="buttons-container">
            <button class="print-button" onclick="window.print()">Print Bill</button>
            <button class="home-button" onclick="window.location.href='home_kanha.html'">Home Page</button>
        </div>
    </div>
</body>
</html>
