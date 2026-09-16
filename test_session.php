<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - National Park</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Contact Us</h2>
        <form action="#" method="post">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Your full name.." required>
           
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Your email.." required>
           
            <label for="country">Country</label>
            <select id="country" name="country">
                <option value="USA">United States</option>
                <option value="Canada">Canada</option>
                <option value="Australia">Australia</option>
                <option value="India">United Kingdom</option>
                <option value="other">Other</option>
            </select>
           
            <label for="message">Message</label>
            <textarea id="message" name="message" placeholder="Write your message here.." rows="5" required></textarea>
           
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>

