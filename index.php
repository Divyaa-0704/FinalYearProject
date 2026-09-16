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
        .navbar {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            transition: top 0.3s;
        }
        .nav-links {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 40px;
            margin-left: 300px;
        }
        .nav-links a {
            text-decoration: none;
            font-size: 22px;
            color: black;
            font-weight: bold;
            padding: 12px 15px;
        }
        .right-section {
            display: flex;
            align-items: center;
            gap: 40px;
            margin-right: 100px;
        }
        .dropdown select {
            padding: 12px;
            font-size: 18px;
            border-radius: 8px;
            border: 1px solid #ccc;
            cursor: pointer;
            width: 215px;
        }
        .carousel {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            margin-top: 85px;
        }
        .carousel img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
            position: absolute;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .carousel img.active {
            opacity: 1;
        }
        .content-container {
            background: rgba(255, 248, 240, 0.95);
            padding: 30px;
            text-align: center;
            margin: 30px auto;
            width: 80%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .footer {
            width: 100%;
            background: #8B4513;
            color: white;
            text-align: center;
            padding: 20px 0;
        }
        .footer .social-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 10px;
        }
        .footer a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: center;
            }
            .nav-links {
                flex-direction: column;
                text-align: center;
            }
            .carousel {
                margin-top: 100px;
            }
        }
        .animals-section {
            text-align: center;
            padding: 20px 10px;
        }
        .animals-section h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .highlight-box {
            background-color: #8B4513;
            padding: 10px;
            border-radius: 10px;
            margin: 0 auto 20px auto;
            max-width: 800px;
            margin-bottom: 30px;
        }
        .marquee-container {
            overflow: hidden;
            white-space: nowrap;
            margin: 15px auto;
            width: 100%;
        }
        .highlight-text {
            color: white;
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }
        .marquee {
            display: inline-block;
            animation: scroll-left 10s linear infinite;
        }
        .marquee img {
            width: 250px;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 20px;
        }
        .reverse .marquee {
            animation: scroll-right 10s linear infinite;
        }
        @keyframes scroll-left {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(-100%);
            }
        }
        @keyframes scroll-right {
            from {
                transform: translateX(-100%);
            }
            to {
                transform: translateX(100%);
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="our_history_kanha.html">Our History</a></li>
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
    <div class="animals-section">
        <h2>Our Animals</h2>
        <div class="highlight-box">
            <p class="highlight-text">Experience the beauty of the wild like never before!</p>
            <p class="highlight-text">From the majestic roar of the tiger to the playful antics of the red panda, discover nature’s wonders.</p>
            <p class="highlight-text">Plan your visit today and embark on an unforgettable adventure!</p>
        </div>
        <div class="marquee-container">
            <div class="marquee">
                <img src="animal1.png" alt="Animal 1">
                <img src="animal2.png" alt="Animal 2">
                <img src="animal3.png" alt="Animal 3">
            </div>
        </div>
        <div class="marquee-container reverse">
            <div class="marquee">
                <img src="animal4.png" alt="Animal 4">
                <img src="animal5.png" alt="Animal 5">
                <img src="animal6.png" alt="Animal 6">
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="social-links">
            <a href="#">Instagram</a>
            <a href="#">Twitter</a>
            <a href="#">Facebook</a>
            <a href="#">Google</a>
        </div>
        <p>Contact us: example@example.com | +123 456 7890 | www.nationalparks.com</p>
    </footer>
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
        let lastScrollTop = 0;
        const navbar = document.querySelector(".navbar");
        window.addEventListener("scroll", function () {
            let scrollTop = window.scrollY;
            if (scrollTop > lastScrollTop) {
                navbar.style.top = "-80px";
            } else {
                navbar.style.top = "0";
            }
            lastScrollTop = scrollTop;
        });
    </script>
</body>
</html>
