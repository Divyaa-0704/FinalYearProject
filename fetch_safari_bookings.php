<?php
require_once __DIR__ . '/db_connect.php';

header('Content-Type: application/json');

$date = isset($_GET['date']) ? $_GET['date'] : '';

if ($date) {
    $sql = "SELECT * FROM bookings WHERE DATE(datetime) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(["message" => "No date selected"]);
}
$conn->close();
?>
