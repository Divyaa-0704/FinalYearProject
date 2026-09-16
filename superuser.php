<script>
    window.onload = function() {
        alert("Welcome, Super User!");
    };
</script>
<?php
session_start();
require 'db_connect.php'; 
if (!isset($_SESSION['role']) || strtolower(trim($_SESSION['role'])) !== 'super user') {
    header("Location: kanha_login.php");
    exit();
}
$username = $_SESSION['username'] ?? 'Super User';
$query = "
    SELECT 
        (SELECT COUNT(*) FROM animals) AS total_animals, 
        (SELECT COUNT(*) FROM users WHERE role = 'Employee') AS total_employees, 
        (SELECT COUNT(*) FROM contact_us) AS people_contacted, 
        (SELECT COUNT(*) FROM visitors) AS total_visitors
";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$total_animals = $data['total_animals'] ?? 0;
$total_employees = $data['total_employees'] ?? 0;
$people_contacted = $data['people_contacted'] ?? 0;
$total_visitors = $data['total_visitors'] ?? 0;
$animal_chart_query = "SELECT animal_type, COUNT(*) AS count FROM animals GROUP BY animal_type";
$chart_result = mysqli_query($conn, $animal_chart_query);
$animal_types = [];
$animal_counts = [];
while ($row = mysqli_fetch_assoc($chart_result)) {
    $animal_types[] = $row['animal_type'];
    $animal_counts[] = $row['count'];
}
$category_chart_query = "SELECT category, COUNT(*) AS count FROM animals GROUP BY category";
$category_result = mysqli_query($conn, $category_chart_query);
$animal_categories = [];
$category_counts = [];
while ($row = mysqli_fetch_assoc($category_result)) {
    $animal_categories[] = $row['category'];
    $category_counts[] = $row['count'];
}
$expenses_query = "SELECT amount FROM expenses";
$expenses_result = mysqli_query($conn, $expenses_query);
$maintenance_query = "SELECT cost FROM maintenance";
$maintenance_result = mysqli_query($conn, $maintenance_query);
$expenses_data = [];
$maintenance_data = [];
while ($row = mysqli_fetch_assoc($expenses_result)) {
    $expenses_data[] = $row['amount'];
}
while ($row = mysqli_fetch_assoc($maintenance_result)) {
    $maintenance_data[] = $row['cost'];
}
$giraffe_query = "SELECT COUNT(*) AS count FROM bookings WHERE package = 'giraffe'";
$safari_query = "SELECT COUNT(*) AS count FROM bookings WHERE package = 'safari'";
$bird_query = "SELECT COUNT(*) AS count FROM bookings WHERE package = 'bird'";
$giraffe_count = mysqli_fetch_assoc(mysqli_query($conn, $giraffe_query))['count'];
$safari_count = mysqli_fetch_assoc(mysqli_query($conn, $safari_query))['count'];
$bird_count = mysqli_fetch_assoc(mysqli_query($conn, $bird_query))['count'];
$statusQuery = "SELECT Status, COUNT(*) AS count FROM rescueoperations GROUP BY Status";
$statusResult = $conn->query($statusQuery);
$rescueStatuses = [];
$statusCounts = [];
if ($statusResult->num_rows > 0) {
    while ($row = $statusResult->fetch_assoc()) {
        $rescueStatuses[] = $row['Status'];
        $statusCounts[] = $row['count'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superuser Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3e5d8;
        }
        
        .header {
            background: #8B5A2B;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 22px;
        }
        .dropdown-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        select {
            padding: 8px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
        }
        .logout {
            padding: 8px 15px;
            background-color: #5C4033;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }
        .logout:hover {
            background-color: #3D2B1F;
        }
        .overview {
            background: #e6ded3;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }
        .overview-card {
            background: #f8f1e7;
            padding: 15px;
            border-radius: 10px;
            flex: 1;
            margin: 10px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.1);
            min-width: 150px;
        }
        .overview-card:nth-child(4) {
            background: #eec3a5;
        }
        .overview-card span {
            display: block;
            font-size: 22px;
            color: #8B5A2B;
        }
        .charts-container {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 20px;
            margin: 30px auto;
            width: 90%;
        }
        .chart-box {
            width: 400px;
            height: 500px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .line-chart-box {
            flex: 1; 
            width: 20%;
            height: 500px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }
        .booking-container {
            display: flex;
            justify-content: center; 
            text-align: center;
            gap: 135px;
            padding: 40px;
            margin-top: 10px;
            margin-left: 50px;
            overflow-x: auto; 
            white-space: nowrap;
        }
        .booking-block {
            display: flex;
            flex-direction: column;
            justify-content: center; 
            align-items: center; 
            text-align: center;
            min-width: 250px; 
            min-height: 120px; 
            padding: 15px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }
        .giraffe {
            background-color: #ff9f1a;  
        }
        .safari {
            background-color: #2a9d8f; 
        }
        .bird {
             background-color: #e76f51; 
        }
        .booking-container::-webkit-scrollbar {
             height: 8px;
        }
            .booking-container::-webkit-scrollbar-thumb {
                background: #8B5A2B;
                border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Welcome Super User</h2>
        <div>
            
        </div>
        
        <div class="dropdown-container">
            <select id="dashboardDropdown" onchange="openDashboard(this.value)">
                <option value="">-- Select Dashboard --</option>

                <option value="dashboard.html">Kanha National Park</option>
                <option value="aranya">Aranya National Park</option>
            </select>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </div>
    <div class="overview">
        <div class="overview-card">
            <span><?= $total_animals ?></span>
            Total Animals
        </div>
        <div class="overview-card">
            <span><?= $total_employees ?></span>
            Total Employees
        </div>
        <div class="overview-card">
            <span><?= $people_contacted ?></span>
            People Contacted
        </div>
        <div class="overview-card">
            <span><?= $total_visitors ?></span>
            Total Visitors
        </div>
    </div>
    <label for="bookingDate">Select Date:</label>
<input type="date" id="bookingDate">
<button id="checkSafariBooking">Check Safari Booking</button>
<div id="safariBookings"></div>


    <div class="charts-container">
        <div class="chart-box">
            <canvas id="animalChart"></canvas>
        </div>
        <div class="chart-box">
            <canvas id="categoryChart"></canvas>
        </div>
        <div class="line-chart-box">
    <canvas id="expensesChart"></canvas>
</div>
    </div>
<div class="booking-container">
    <div class="booking-block giraffe">
        <h3>Giraffe Package</h3>
        <p>Bookings: <?= $giraffe_count ?></p>
    </div>
    <div class="booking-block safari">
        <h3>Safari Package</h3>
        <p>Bookings: <?= $safari_count ?></p>
    </div>
    <div class="booking-block bird">
        <h3>Bird Package</h3>
        <p>Bookings: <?= $bird_count ?></p>
    </div>
</div>
    <script>
   function openDashboard(selectedValue) {
    if (selectedValue === "dashboard.html") {
        window.location.href = "dashboard_kanha.php";
    } else if (selectedValue === "aranya") {
        window.location.href = "dashboard_aranya.php";
    }
}
function fetchBookings() {
    let selectedDate = document.getElementById("bookingDate").value;

    if (!selectedDate) {
        alert("Please select a date!");
        return;
    }

    fetch("fetch_safari_bookings.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "date=" + selectedDate
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("totalBookings").innerText = data.total;
    })
    .catch(error => console.error("Error:", error));
}
    var ctx = document.getElementById('animalChart').getContext('2d');
    var animalChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($animal_types) ?>,
            datasets: [{
                label: 'Number of Animals by Type',
                data: <?= json_encode($animal_counts) ?>,
                backgroundColor: ['#8B4513', '#A0522D', '#CD853F'],
                borderColor: '#654321',
                borderWidth: 2
            }]
        },
        options: { 
    responsive: true, 
    maintainAspectRatio: false, 
    scales: { y: { beginAtZero: true } } 
}
    });
    var ctx2 = document.getElementById('categoryChart').getContext('2d');
    var categoryChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($animal_categories) ?>,
            datasets: [{
                data: <?= json_encode($category_counts) ?>,
                backgroundColor: ['#8B4513', '#A0522D', '#CD853F', '#D2691E', '#DEB887']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'top' } } }
    });
    new Chart(document.getElementById('expensesChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: [...Array(<?= count($expenses_data) ?>).keys()], // X-axis labels (auto-generated index)
        datasets: [{
            label: 'Expenses',
            data: <?= json_encode($expenses_data) ?>,
            borderColor: '#8B4513', // Brown
            backgroundColor: 'rgba(139, 69, 19, 0.2)', // Light brown fill
            fill: true
        }, {
            label: 'Maintenance Cost',
            data: <?= json_encode($maintenance_data) ?>,
            borderColor: '#D2691E', // Lighter brown
            backgroundColor: 'rgba(210, 105, 30, 0.2)', // Light brown fill
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
    </script>
</body>
</html>
