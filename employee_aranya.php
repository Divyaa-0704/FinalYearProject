<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Employee') {
    header("Location: login_kanha.php");
    exit();
}

// Database connection
require_once __DIR__ . '/db_connect.php';

// Fetch employee name
$user_id = $_SESSION['user_id'];
$sql = "SELECT name FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$employee_name = $user['name'];
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - Kanha</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f1e9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar {
            background-color: #5a3e2b;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            position: fixed;
            height: 70px;
            top: 0;
            width: 100%;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: top 0.3s ease-in-out; /* Smooth transition */

}

        
        .navbar .logo img {
            height: 170px;
            cursor: pointer;
        }
        .nav-right {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-right: 80px;
        }
        .dropdown {
            position: relative;
        }
        .dropbtn {
            background-color: #7b9c6c;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 200px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 40px;
        }
        .dropdown-content a {
            color: black;
            padding: 10px;
            display: block;
            text-decoration: none;
            background-color: #7b9c6c;
            font-weight: bold;
        }
        .dropdown-content a:hover {
            background-color: #5e7c51;
            color: white;
        }
        .logout {
            background-color: #7b9c6c;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout:hover {
            background-color: #5e7c51;
        }
        .container {
            margin-top: 80px;
            padding: 20px;
            flex: 1;
        }
        .rules {
            background-color: white;
            padding: 20px;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .rules h3 {
            color: #5a3e2b;
        }
        .rules ul {
            list-style-type: disc;
            padding-left: 20px;
        }
        .rules ul li {
            padding: 5px 0;
        }
        .footer {
            background-color: #5a3e2b;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
            font-size: 14px;
        }
    </style>
    <script>
        window.onload = function() {
            alert("Welcome Employee, <?php echo $employee_name; ?>!");
        };

        function toggleDropdown() {
            var dropdown = document.getElementById("dropdown-menu");
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";
            }
        }

        document.addEventListener("click", function(event) {
            var dropdown = document.getElementById("dropdown-menu");
            var dropbtn = document.getElementById("dropbtn");
            
            if (!dropbtn.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = "none";
            }
        });
        

    </script>
</head>
<body>
    <div class="navbar">
        <a href="home_aranya.html" class="logo"><img src="aranya_logo.png" alt="Aranya Employee Dashboard"></a>

        <div class="nav-right">
            <div class="dropdown">
                <button id="dropbtn" class="dropbtn" onclick="toggleDropdown()">Tasks</button>
                <div id="dropdown-menu" class="dropdown-content">
                    <a href="view_animals_aranya.php">Manage Animals</a>
                    <a href="assign_safari_aranya.php">Assign Safari Vehicles</a>
                </div>
            </div>

            <a href="logout_aranya.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="container">
        <h2>Welcome, <?php echo $employee_name; ?></h2><br>

        <div class="rules">
            <h3>🦺 Employee Rules & Guidelines – Kanha National Park</h3>
            <ul>
                <li><strong>General Conduct:</strong></li>
                <ul>
                    <li>Maintain professionalism and integrity at all times.</li>
                    <li>Follow all national park rules and government regulations.</li>
                    <li>Respect wildlife and avoid any actions that may disturb the animals.</li>
                    <li>Always wear the official uniform and ID badge during duty hours.</li>
                </ul>

                <li><strong>🦣 Wildlife & Habitat Protection:</strong></li>
                <ul>
                    <li>Do not feed or provoke animals under any circumstances.</li>
                    <li>Keep a safe distance from all wildlife, especially during safaris and rescue operations.</li>
                    <li>Report any injured or sick animals to the veterinarian immediately.</li>
                    <li>Prevent unauthorized entry of tourists or outsiders into restricted areas.</li>
                </ul>

                <li><strong>🛻 Safari & Visitor Management:</strong></li>
                <ul>
                    <li>Ensure all safari vehicles are assigned based on bookings and are in good condition.</li>
                    <li>Guide visitors responsibly, providing accurate and respectful information about wildlife.</li>
                    <li>Monitor and report any illegal activities, such as poaching or littering.</li>
                    <li>Assist tourists in case of emergencies and follow safety protocols.</li>
                </ul>
                <li><strong>🧹 Maintenance & Safety:</strong></li>
                <ul>
                    <li>Keep enclosures, trails, and visitor areas clean and well-maintained.</li>
                    <li>Follow the park’s waste management policy and dispose of garbage responsibly.</li>
                    <li>Report any broken fences, damaged pathways, or unsafe conditions to the administration.</li>
                    <li>Participate in fire safety and emergency drills regularly.</li>
                </ul>

                <li><strong>📊 Work Ethics & Responsibilities:</strong></li>
                <ul>
                    <li>Arrive on time and complete assigned tasks efficiently.</li>
                    <li>Log all activities, including feeding, cleaning, and medical checkups, in the system.</li>
                    <li>Cooperate with veterinarians, researchers, and security teams for smooth park operations.</li>
                    <li>Seek prior approval for leaves and shift changes.</li>
                </ul>

                <li><strong>❌ Prohibited Actions:</strong></li>
                <ul>
                    <li>Strictly no smoking, alcohol, or drug consumption within the park premises.</li>
                    <li>Do not engage in bribery or unauthorized commercial activities.</li>
                    <li>Avoid using mobile phones during duty hours unless for official purposes.</li>
                    <li>Do not share sensitive park-related information with unauthorized individuals.</li>
                </ul>
            </ul>
        </div>
    </div><br><br>

    <div class="footer">
        © 2025 Aranya National Park. All Rights Reserved.
    </div>
</body>
</html>
