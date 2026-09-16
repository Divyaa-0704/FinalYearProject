<?php
session_start();
require_once __DIR__ . '/db_connect.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$package = $_POST['package'];
$tickets = $_POST['tickets'];
$datetime = $_POST['datetime'];
$park_id = $_POST['park_id'];

$_SESSION['booking'] = [
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'package' => $package,
    'tickets' => $tickets,
    'datetime' => $datetime,
    'park_id' => $park_id
];

$sql = "INSERT INTO bookings (name, email, phone, package, tickets, datetime, park_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssisi", $name, $email, $phone, $package, $tickets, $datetime, $park_id);

if ($stmt->execute()) {
    header("Location: bill_kanha.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
