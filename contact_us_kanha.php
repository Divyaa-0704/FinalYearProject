<?php
require_once __DIR__ . '/db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);
    $message = $conn->real_escape_string($message);
    $sql = "INSERT INTO contact_us (name, email, message,park_id) VALUES ('$name', '$email', '$message',1)";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Thank you for contacting us!');
                setTimeout(function() {
                    window.location.href = 'home_kanha.html';
                }, 1000);
              </script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
            body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(148, 105, 78); 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            display: flex;
            width: 80%;
            max-width: 900px;
            background-color: #fff; 
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .contact-form {
            flex: 1;
            background-color: #fff;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .contact-form h2 {
            color: rgb(159, 88, 53); 
            margin-bottom: 10px;
        }
        .contact-form p {
            color: #555;
            margin-bottom: 20px;
        }
        .contact-form input, 
        .contact-form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .contact-form textarea {
            height: 100px;
            resize: none;
        }
        .contact-form button {
            background-color: rgb(120, 70, 37); 
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .contact-form button:hover {
            background-color: rgb(187, 130, 95); 
        }
        .contact-info {
            flex: 1;
            background-color: rgb(104, 64, 38); 
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .contact-info h2 {
            margin-bottom: 20px;
        }
        .contact-info p {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }
        .contact-info img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .contact-info, .contact-form {
                padding: 20px;
                text-align: center;
            }

            .contact-info p {
                justify-content: center;
            }
        }
    </style>
    <script>
        function disableButton() {
            document.getElementById("submit-btn").disabled = true;
            document.getElementById("submit-btn").innerText = "Sending...";
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="contact-form">
            <h2>Contact Us</h2>
            <p>Feel free to contact us anytime. We will get back to you as soon as we can!</p>
            <form method="POST" onsubmit="disableButton()">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" required></textarea>
                <button type="submit" id="submit-btn">Send Message</button>
            </form>
        </div>
        <div class="contact-info">
            <h3>Contact Details</h3>
            <p><i>📧</i> support@nationalpark.com</p>
            <p><i>📞</i> +24 56 89 146</p>
            <p><i>📍</i> 14 Greenroad St.</p>
            <p><i>⏰</i> 09:00 - 18:00</p>
        </div>
    </div>
</body>
</html>
