<?php
require_once __DIR__ . '/db_connect.php';

// Get animal ID from URL
$animal_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$animal_name = "";

if ($animal_id > 0) {
    $query = "SELECT Name FROM animals WHERE Animal_ID = $animal_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $animal_name = $row['Name'];
    } else {
        echo "<script>alert('Animal not found!'); window.location.href='index.php';</script>";
        exit();
    }
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
            background-color:rgb(198, 157, 110);
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
        <h2>Adopt <?php echo htmlspecialchars($animal_name); ?></h2>
        <form action="submit_adoption.php" method="POST">
            <input type="hidden" name="animal_id" value="<?php echo $animal_id; ?>">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="text" name="phone" placeholder="Your Phone" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <button type="submit">Adopt <?php echo htmlspecialchars($animal_name); ?></button>
        </form>
    </div>
</body>
</html>
