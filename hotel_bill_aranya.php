<?php
// Database Connection
require_once __DIR__ . '/db_connect.php';

// Collect Form Data
$package = $_POST['package'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$tickets = $_POST['tickets'];
$datetime = $_POST['datetime'];
$park_id = 2; // Automatically setting park_id as 1

// Check if 'park_id' exists in table (avoid SQL errors)
$check_column = $conn->query("SHOW COLUMNS FROM hotel_bookings LIKE 'park_id'");
if ($check_column->num_rows === 0) {
    die("Error: Column 'park_id' does not exist in 'hotel_bookings' table.");
}

// Insert Data into `hotel_bookings` Table
$sql = "INSERT INTO hotel_bookings (package_name, full_name, email, phone_number, num_tickets, booking_datetime, park_id) 
        VALUES ('$package', '$name', '$email', '$phone', '$tickets', '$datetime', '$park_id')";

if ($conn->query($sql) === TRUE) {
    $booking_id = $conn->insert_id;
} else {
    die("Error: " . $sql . "<br>" . $conn->error);
}

// Close Connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Booking Confirmation</title>
</head>
<body class="flex items-center justify-center min-h-screen bg-[#EDE0D4]">
    <div class="bg-[#D2B48C] p-8 rounded-lg shadow-lg w-96 border border-[#A67B5B]">
        <h2 class="text-xl font-bold text-center text-[#6B4226]">Booking Confirmed!</h2>

        <p class="mt-4 text-[#5C4033]"><strong>Booking ID:</strong> <?php echo $booking_id; ?></p>
        <p class="text-[#5C4033]"><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p class="text-[#5C4033]"><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p class="text-[#5C4033]"><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
        <p class="text-[#5C4033]"><strong>Package:</strong> <?php echo htmlspecialchars($package); ?></p>
        <p class="text-[#5C4033]"><strong>Tickets:</strong> <?php echo htmlspecialchars($tickets); ?></p>
        <p class="text-[#5C4033]"><strong>Check-in:</strong> <?php echo htmlspecialchars($datetime); ?></p>
        <p class="text-[#5C4033]"><strong>Park ID:</strong> <?php echo $park_id; ?></p>

        <p class="mt-6 text-center text-[#6B4226] font-bold">Thank you for booking with us!</p>
        <a href="home_kanha.html" class="block text-center bg-[#8B5A2B] text-white font-bold py-2 mt-4 rounded hover:bg-[#6B4226]">
            Go to Dashboard
        </a>
    </div>
</body>
</html>
