<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Booking System</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px 10px;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #8B5A2B, #CD853F);
        }
        .container {
            background: #F5DEB3;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 440px;
            text-align: center;
            box-sizing: border-box;
        }
        .section {
            margin-bottom: 20px;
        }
        h1 {
            color: #5A3825;
            font-size: 26px;
            margin-bottom: 15px;
        }
        h2 {
            color: #6D4C41;
            font-size: 18px;
            margin-bottom: 10px;
        }
        input, select, button {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border-radius: 8px;
            border: 1px solid #8B5A2B;
            font-size: 16px;
            box-sizing: border-box;
        }
        select, input {
            background: #FFE4B5;
        }
        button {
            background: #A0522D;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            transition: background 0.3s, transform 0.2s;
            font-weight: bold;
            margin-top: 15px;
        }
        button:hover {
            background: #8B4513;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Zoo Ticket Booking</h1>
        
        <form id="bookingForm">
            <div class="section">
                <h2>Select Package</h2>
                <select name="package" id="package" required>
                    <option value="select">Select Package</option>
                    <option value="giraffe">Giraffe Feeding</option>
                    <option value="safari">Safari</option>
                    <option value="bird">Bird Sanctuary</option>
                </select>
            </div>
            <div class="section">
                <h2>Your Information</h2>
                <input type="text" name="name" id="name" placeholder="Full Name" required>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="tel" name="phone" id="phone" placeholder="Phone Number" required>
                <input type="number" name="tickets" id="tickets" placeholder="Number of Tickets" min="1" value="1" required>
                <input type="datetime-local" name="datetime" id="datetime" required>
                <input type="hidden" name="park_id" value="1">
            </div>
            <button type="submit">Confirm Booking</button>
        </form>
    </div>
    <script>
        document.getElementById("bookingForm").addEventListener("submit", function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            fetch("save_booking_kanha.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert("Booking Confirmed! Redirecting to Bill...");
                window.location.href = "bill_kanha.php";
            })
            .catch(error => console.error("Error:", error));
        });
    </script>
</body>
</html>
