<?php
session_start();
if (!isset($_SESSION['booking'])) {
    echo "No booking found.";
    exit();
}
$booking = $_SESSION['booking'];
$package_details = [
    'giraffe' => ['name' => 'Giraffe Feeding Experience', 'price' => 500],
    'safari' => ['name' => 'Wildlife Safari Adventure', 'price' => 1000],
    'bird' => ['name' => 'Bird Sanctuary Exploration', 'price' => 700]
];
$package_key = $booking['package'];
$package_name = $package_details[$package_key]['name'];
$total_price = $booking['tickets'] * $package_details[$package_key]['price'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Bill</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #FAF3E0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
            margin: 0;
            padding-top: 110px;
            box-sizing: border-box;
        }
        .navbar {
            width: 100%;
            background: #8B4513;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 90px;
        }
        .navbar img {
            width: 170px;
            height: auto;
            cursor: pointer;
        }
        .logout-button {
            background: #F5DEB3;
            color: #8B4513;
            border: none;
            padding: 8px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 70px;
        }
        .logout-button:hover {
            background: #DEB887;
        }
        .container {
            width: 100%;
            max-width: 500px;
            margin-top: 20px;
            margin-bottom: 40px;
            padding: 0 15px;
            box-sizing: border-box;
        }
        .bill-container {
            background: #F5DEB3;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
        }
        h1 {
            color: #5A3825;
        }
        p {
            font-size: 18px;
            color: #6D4C41;
            margin: 5px 0;
        }
        .total {
            font-size: 22px;
            font-weight: bold;
            color: #8B4513;
            margin-top: 10px;
        }
        button {
            background: #A0522D;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            padding: 10px 15px;
            border-radius: 8px;
            margin-top: 15px;
        }
        button:hover {
            background: #8B4513;
        }
        .footer {
            width: 100%;
            background: #8B4513;
            color: white;
            text-align: center;
            padding: 14px 0;
            margin-top: auto;
            position: relative;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="home_kanha.html">
            <img src="logo.png" alt="Home" onerror="this.onerror=null; this.src='fallback_logo.png';">
        </a>
        <button class="logout-button" onclick="window.location.href='logout.php';">Logout</button>
    </div>
    <div class="container">
        <div class="bill-container">
            <h1>Booking Confirmation</h1>
            <p><strong>Name:</strong> <?= htmlspecialchars($booking['name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($booking['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($booking['phone']) ?></p>
            <p><strong>Package:</strong> <?= htmlspecialchars($package_name) ?></p>
            <p><strong>Tickets:</strong> <?= htmlspecialchars($booking['tickets']) ?></p>
            <p><strong>Date & Time:</strong> <?= htmlspecialchars($booking['datetime']) ?></p>
            <p class="total">Total: ₹<?= number_format($total_price) ?></p>
            <button onclick="window.print()">Print Bill</button>
        </div>
    </div>
    <div class="footer">
    © 2025 Kanha National Park. All Rights Reserved.
    </div>
</body>
</html>
