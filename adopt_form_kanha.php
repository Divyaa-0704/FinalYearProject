<?php
require_once __DIR__ . '/db_connect.php';

// Get animal ID from URL
$animal_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$animal_name = "";
$status = "";

if ($animal_id > 0) {
    $query = $conn->prepare("SELECT Name, Status FROM animals WHERE Animal_ID = ?");
    $query->bind_param("i", $animal_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $animal_name = htmlspecialchars($row['Name']);
        $status = $row['Status'];

        // Prevent adoption if already adopted
        if ($status === 'Adopted') {
            echo "<script>alert('This animal is already adopted!'); window.location.href='adopt_kanha.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Animal not found!'); window.location.href='adopt_kanha.php';</script>";
        exit();
    }
    $query->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if ($animal_id == 0 || empty($name) || empty($phone) || empty($email)) {
        echo "<script>alert('Please fill in all fields!'); window.history.back();</script>";
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!'); window.history.back();</script>";
        exit();
    }

    // Update the `animals` table with adopter details
    $updateQuery = $conn->prepare("UPDATE animals SET Status = 'Adopted', Adopter_Name = ?, Adopter_Phone = ?, Adopter_Email = ? WHERE Animal_ID = ?");
    $updateQuery->bind_param("sssi", $name, $phone, $email, $animal_id);

    if ($updateQuery->execute()) {
        // Insert into `adopt_booking` table
        $insertQuery = $conn->prepare("INSERT INTO adopt_booking (name, phone, email, animal, adoption_date) VALUES (?, ?, ?, ?, NOW())");
        $insertQuery->bind_param("ssss", $name, $phone, $email, $animal_name);
        
        if ($insertQuery->execute()) {
            $booking_id = $conn->insert_id;
            echo "<script>alert('Adoption successful! Redirecting to Bill...');
                  window.location.href='bill_adopt_kanha.php?booking_id=$booking_id';</script>";
            exit();
        } else {
            echo "<script>alert('Error saving adoption details. Please try again.');
                  window.history.back();</script>";
        }

        $insertQuery->close();
    } else {
        echo "<script>alert('Error in adoption process. Please try again.');
              window.history.back();</script>";
    }

    $updateQuery->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt an Animal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(198, 157, 110);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .icon {
            font-size: 50px;
            color: brown;
        }
        input {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        button {
            background-color: #8B4513;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
        }
        button:hover {
            background-color: #5A2D0C;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">&#129417;</div>
        <h2>Adopt <?php echo $animal_name; ?></h2>
        <form method="POST">
            <input type="hidden" name="animal_id" value="<?php echo $animal_id; ?>">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="text" name="phone" placeholder="Your Phone" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <button type="submit">Adopt <?php echo $animal_name; ?></button>
        </form>
    </div>
</body>
</html>
