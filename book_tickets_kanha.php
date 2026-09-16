<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wildlife Safari Booking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #d2a77d;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        nav {
            background-color: #7a4c1f;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            height: 80px;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .logo img {
            width: 140px;
            height: auto;
        }
        .nav-links {
            list-style: none;
            display: flex;
            margin-left: 70px;
        }
        .nav-links li {
            margin: 0 15px;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 25px;
            transition: 0.3s;
        }
        .nav-links a:hover {
            color: #FFD700; 
        }
        .content-wrapper {
            flex: 1; 
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding-top: 100px;
        }
        .container {
            display: flex;
            gap: 20px;
            align-items: stretch;
            margin-bottom: 20px;
        }
        .card {
            width: 320px;
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }
        .card img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
        }
        .card h2 {
            margin: 15px 0 5px;
            font-size: 22px;
            text-transform: uppercase;
        }
        .card p {
            font-size: 16px;
            min-height: 50px;
            margin-bottom: 10px;
        }
        .green { color: #2f6d32; }
        .gold { color: #b68d40; }
        .purple { color: #4b3e8a; }
        .button-container {
            text-align: center;
        }
        .book-btn {
            padding: 12px 15px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            color: #fff;
            background: #8B4513;
            width: 200px;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }
        .book-btn:hover {
            opacity: 0.8;
        }
        footer {
            background-color: #7a4c1f;
            color: white;
            text-align: center;
            padding: 20px;
            width: 100%;
        }
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            font-weight: bold;
        }
        .footer-links a {
            color: white;
            text-decoration: none;
        }
        .footer-links a:hover {
            text-decoration: underline;
        }
        .footer-contact a {
            color: #FFD700;
            text-decoration: none;
        }
        .footer-contact a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo">
            <a href="home_kanha.html">
                <img src="logo.png" alt="Kanha National Park Logo">
            </a>
        </div>
        <ul class="nav-links">
            <li><a href="home_kanha.html">Home</a></li>
            <li><a href="our_history_kanha.html">Our History</a></li>
            <li><a href="contact_us_kanha.php">Contact Us</a></li>
        </ul>
    </nav><br><br>
    <div class="content-wrapper">
        <div class="container">
            <div class="card">
                <img src="feed_giraffe.jpg" alt="Giraffe Feeding">
                <h2 class="green">GIRAFFE FEEDING</h2>
                <p>Meet the giraffe family at the Giraffe Feeding station.</p>
            </div>
            <div class="card">
                <img src="safari.jpg" alt="Safari">
                <h2 class="gold">SAFARI</h2>
                <p>Experience nature like never before.</p>
            </div>
            <div class="card">
                <img src="birds.jpg" alt="Bird Sanctuary">
                <h2 class="purple">BIRD SANCTUARY</h2>
                <p>Adventure awaits in the wilderness.</p>
            </div>
        </div>
        <div class="button-container">
            <a href="booking_kanha.php" class="book-btn">Book Now</a>
        </div>
    </div><br><br>
    <footer>
        <div>
            <div class="footer-links">
                <a href="#">Instagram</a>
                <a href="#">Twitter</a>
                <a href="#">Facebook</a>
            </div>
            <p class="footer-contact" style="margin-top: 10px;">
                Contact us: kanhanationalpark@gmail.com | +91 9916935156 / +91 7019223327 |
                <a href="https://bannerughattabiopark.org/" target="_blank">
                    https://bannerughattabiopark.org
                </a>
            </p>
        </div>
    </footer>
</body>
</html>
