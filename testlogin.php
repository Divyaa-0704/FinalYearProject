<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>National Parks Selection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .header-container {
            width: 100%;
            height: 70px;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            background: white;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .logo {
            height: 60px;
        }
        .nav-links {
            display: flex;
            list-style: none;
            padding: 0;
            gap: 20px;
        }
        .nav-links a {
            text-decoration: none;
            font-size: 18px;
            color: black;
            font-weight: bold;
        }
        .right-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .dropdown select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            cursor: pointer;
            width: 220px;
        }
        .carousel {
            position: relative;
            width: 100%;
            height: calc(100vh - 70px);
            overflow: hidden;
            top: 70px;
        }
        .carousel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .carousel img.active {
            opacity: 1;
        }
        .content-section {
            padding: 50px 30px;
            font-size: 18px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <img src="logo.png" class="logo" alt="Logo">
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="our_history.html">Our History</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
        </ul>
        <div class="right-section">
            <div class="dropdown">
                <select id="parkSelection" onchange="navigateToPark()">
                    <option value="">Select National Park</option>
                    <option value="home_kanha.html">Kanha National Park</option>
                    <option value="home_aranya.html">Aranya National Park</option>
                </select>
            </div>
        </div>
    </div>
    <div class="carousel">
        <img src="tiger3.jpg" class="active" alt="National Park 1">
        <img src="peacock.jpg" alt="National Park 2">
        <img src="lion.jpg" alt="National Park 3">
        <img src="koala.jpg" alt="National Park 4">
        <img src="kangaroo.jpg" alt="National Park 5">
    </div>
    <div class="content-section">
        <h2>Welcome to the National Parks Portal</h2>
        <p>Explore the beauty of nature with our curated selection of national parks. Learn about their rich history, diverse wildlife, and breathtaking landscapes.</p>
    </div>
    <script>
        function navigateToPark() {
            let selectedPark = document.getElementById("parkSelection").value;
            if (selectedPark) {
                window.location.href = selectedPark;
            }
        }
        document.addEventListener("DOMContentLoaded", function () {
            let images = document.querySelectorAll(".carousel img");
            let currentIndex = 0;
            function changeImage() {
                images[currentIndex].classList.remove("active");
                currentIndex = (currentIndex + 1) % images.length;
                images[currentIndex].classList.add("active");
            }
            setInterval(changeImage, 3000);
        });
    </script>
</body>
</html><?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>National Parks Selection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .header-container {
            width: 100%;
            height: 70px;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            background: white;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .logo {
            height: 60px;
        }
        .nav-links {
            display: flex;
            list-style: none;
            padding: 0;
            gap: 20px;
        }
        .nav-links a {
            text-decoration: none;
            font-size: 18px;
            color: black;
            font-weight: bold;
        }
        .right-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .dropdown select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            cursor: pointer;
            width: 220px;
        }
        .carousel {
            position: relative;
            width: 100%;
            height: calc(100vh - 70px);
            overflow: hidden;
            top: 70px;
        }
        .carousel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .carousel img.active {
            opacity: 1;
        }
        .content-section {
            padding: 50px 30px;
            font-size: 18px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <img src="logo.png" class="logo" alt="Logo">
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="our_history.html">Our History</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
        </ul>
        <div class="right-section">
            <div class="dropdown">
                <select id="parkSelection" onchange="navigateToPark()">
                    <option value="">Select National Park</option>
                    <option value="home_kanha.html">Kanha National Park</option>
                    <option value="home_aranya.html">Aranya National Park</option>
                </select>
            </div>
        </div>
    </div>
    <div class="carousel">
        <img src="tiger3.jpg" class="active" alt="National Park 1">
        <img src="peacock.jpg" alt="National Park 2">
        <img src="lion.jpg" alt="National Park 3">
        <img src="koala.jpg" alt="National Park 4">
        <img src="kangaroo.jpg" alt="National Park 5">
    </div>
    <div class="content-section">
        <h2>Welcome to the National Parks Portal</h2>
        <p>Explore the beauty of nature with our curated selection of national parks. Learn about their rich history, diverse wildlife, and breathtaking landscapes.</p>
    </div>
    <script>
        function navigateToPark() {
            let selectedPark = document.getElementById("parkSelection").value;
            if (selectedPark) {
                window.location.href = selectedPark;
            }
        }
        document.addEventListener("DOMContentLoaded", function () {
            let images = document.querySelectorAll(".carousel img");
            let currentIndex = 0;
            function changeImage() {
                images[currentIndex].classList.remove("active");
                currentIndex = (currentIndex + 1) % images.length;
                images[currentIndex].classList.add("active");
            }
            setInterval(changeImage, 3000);
        });
    </script>
</body>
</html><?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>National Parks Selection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .header-container {
            width: 100%;
            height: 70px;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            background: white;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .logo {
            height: 60px;
        }
        .nav-links {
            display: flex;
            list-style: none;
            padding: 0;
            gap: 20px;
        }
        .nav-links a {
            text-decoration: none;
            font-size: 18px;
            color: black;
            font-weight: bold;
        }
        .right-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .dropdown select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            cursor: pointer;
            width: 220px;
        }
        .carousel {
            position: relative;
            width: 100%;
            height: calc(100vh - 70px);
            overflow: hidden;
            top: 70px;
        }
        .carousel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .carousel img.active {
            opacity: 1;
        }
        .content-section {
            padding: 50px 30px;
            font-size: 18px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <img src="logo.png" class="logo" alt="Logo">
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="our_history.html">Our History</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
        </ul>
        <div class="right-section">
            <div class="dropdown">
                <select id="parkSelection" onchange="navigateToPark()">
                    <option value="">Select National Park</option>
                    <option value="home_kanha.html">Kanha National Park</option>
                    <option value="home_aranya.html">Aranya National Park</option>
                </select>
            </div>
        </div>
    </div>
    <div class="carousel">
        <img src="tiger3.jpg" class="active" alt="National Park 1">
        <img src="peacock.jpg" alt="National Park 2">
        <img src="lion.jpg" alt="National Park 3">
        <img src="koala.jpg" alt="National Park 4">
        <img src="kangaroo.jpg" alt="National Park 5">
    </div>
    <div class="content-section">
        <h2>Welcome to the National Parks Portal</h2>
        <p>Explore the beauty of nature with our curated selection of national parks. Learn about their rich history, diverse wildlife, and breathtaking landscapes.</p>
    </div>
    <script>
        function navigateToPark() {
            let selectedPark = document.getElementById("parkSelection").value;
            if (selectedPark) {
                window.location.href = selectedPark;
            }
        }
        document.addEventListener("DOMContentLoaded", function () {
            let images = document.querySelectorAll(".carousel img");
            let currentIndex = 0;
            function changeImage() {
                images[currentIndex].classList.remove("active");
                currentIndex = (currentIndex + 1) % images.length;
                images[currentIndex].classList.add("active");
            }
            setInterval(changeImage, 3000);
        });
    </script>
</body>
</html>

