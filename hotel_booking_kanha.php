<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Hotel Booking</title>
    <script>
        function validateForm() {
            let package = document.getElementById("package").value;
            let name = document.getElementById("name").value.trim();
            let email = document.getElementById("email").value.trim();
            let phone = document.getElementById("phone").value.trim();
            let tickets = document.getElementById("tickets").value;
            let datetime = document.getElementById("datetime").value;
            let button = document.getElementById("confirmBtn");
            if (package !== "Select Package" && name && email && phone && tickets && datetime) {
                button.disabled = false;
                button.classList.remove("opacity-50", "cursor-not-allowed");
            } else {
                button.disabled = true;
                button.classList.add("opacity-50", "cursor-not-allowed");
            }
        }
        function confirmBooking(event) {
            event.preventDefault(); 
            alert("Confirm Booking\nRedirecting to the bill page...");
            document.getElementById("bookingForm").submit(); 
        }
    </script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-900 via-blue-600 to-blue-300">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-96 border border-blue-400">
        <h2 class="text-2xl font-bold text-center text-blue-800">Hotel Booking</h2>
        
        <form id="bookingForm" action="hotel_bill_kanha.php" method="POST">
            <label class="block mt-4 text-blue-700 font-semibold">Select Package</label>
            <select id="package" name="package" class="w-full p-2 mt-2 rounded-lg border border-blue-500 bg-blue-100 text-blue-900 focus:ring-2 focus:ring-blue-500" onchange="validateForm()">
                <option>Select Package</option>
                <option value="Standard">Standard</option>
                <option value="Deluxe">Deluxe</option>
                <option value="Premium">Premium</option>
            </select>
            <label class="block mt-4 text-blue-700 font-semibold">Your Information</label>
            <input type="text" id="name" name="name" placeholder="Full Name" class="w-full p-2 mt-2 rounded-lg border border-blue-500 bg-blue-100 text-blue-900 focus:ring-2 focus:ring-blue-500" oninput="validateForm()">
            <input type="email" id="email" name="email" placeholder="Email" class="w-full p-2 mt-2 rounded-lg border border-blue-500 bg-blue-100 text-blue-900 focus:ring-2 focus:ring-blue-500" oninput="validateForm()">
            <input type="tel" id="phone" name="phone" placeholder="Phone Number" class="w-full p-2 mt-2 rounded-lg border border-blue-500 bg-blue-100 text-blue-900 focus:ring-2 focus:ring-blue-500" oninput="validateForm()">
            <input type="number" id="tickets" name="tickets" min="1" placeholder="Number of Tickets" class="w-full p-2 mt-2 rounded-lg border border-blue-500 bg-blue-100 text-blue-900 focus:ring-2 focus:ring-blue-500" oninput="validateForm()">
            <input type="datetime-local" id="datetime" name="datetime" class="w-full p-2 mt-2 rounded-lg border border-blue-500 bg-blue-100 text-blue-900 focus:ring-2 focus:ring-blue-500" onchange="validateForm()">
            <button id="confirmBtn" type="submit" onclick="confirmBooking(event)" class="w-full bg-blue-700 text-white font-bold py-2 mt-4 rounded-lg hover:bg-blue-900 opacity-50 cursor-not-allowed transition duration-300" disabled>
                Confirm Booking
            </button>
        </form>
    </div>
</body>
</html>
