<?php
require_once __DIR__ . '/db_connect.php';

// Get form data
$animal_id = isset($_POST['animal_id']) ? intval($_POST['animal_id']) : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

// Check if animal exists and is already adopted
$query = "SELECT Name, Adopter_Name FROM animals WHERE Animal_ID = $animal_id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $animal_name = $row['Name'];

    if (!empty($row['Adopter_Name'])) {
        // Animal is already adopted
        echo "<script>alert('This animal ($animal_name) has already been adopted!'); window.location.href='index.php';</script>";
        exit();
    }

    // Update the animal record with adopter details
    $updateQuery = "UPDATE animals SET Adopter_Name = ?, Adopter_Phone = ?, Adopter_Email = ?, Status = 'Adopted' WHERE Animal_ID = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssi", $name, $phone, $email, $animal_id);

    if ($stmt->execute()) {
        echo "<script>alert('You have successfully adopted $animal_name!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error processing adoption. Please try again!'); window.history.back();</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Animal not found!'); window.location.href='index.php';</script>";
}

$conn->close();
?>
