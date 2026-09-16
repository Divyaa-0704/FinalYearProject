<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt an Animal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Lora:wght@500&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f5f5f5;
            text-align: center;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        /* Full-width Header */
        .header {
            background-color: rgb(92, 41, 0);
            width: 100vw; /* Full viewport width */
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            color: white;
            margin: 0; /* Remove default margin */
            font-family: 'Lora', serif;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            max-width: 1400px;
            margin: auto;
            padding: 10px;
        }

        .card {
            background: white;
            border-radius: 10px;
            perspective: 1000px;
            min-height: 450px;
            cursor: pointer;
        }

        .card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transition: transform 0.6s;
        }

        .card.flipped .card-inner {
            transform: rotateY(180deg);
        }

        .card-front,
        .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-front {
            background: white;
        }

        .card-back {
            background: rgb(92, 41, 0);
            color: white;
            transform: rotateY(180deg);
            text-align: center;
            padding: 20px;
        }

        .card img {
            width: 100%;
            height: 250px;
            border-radius: 10px;
            object-fit: cover;
        }

        .animal-name {
            font-size: 22px;
            font-weight: bold;
            margin: 10px 0;
            font-family: 'Lora', serif;
        }

        .description {
            font-size: 18px;
            font-family: 'Poppins', sans-serif;
            margin-top: 10px;
        }

        .heart {
            cursor: pointer;
            font-size: 22px;
            transition: color 0.3s ease;
        }

        .heart.red {
            color: red;
        }

        .animal-species {
            color: gray;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .animal-status {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .adopt-btn {
            background: rgb(155, 86, 3);
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .adopt-btn:hover {
            background: rgb(31, 1, 1);
        }

        .adopted {
            background: gray !important;
            pointer-events: none;
            cursor: default;
        }

        footer {
            background-color: rgb(92, 41, 0);
            color: white;
            text-align: center;
            padding: 10px;
            width: 100%;
            margin-top: auto;
        }

        @media (max-width: 900px) {
            .container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .container {
                grid-template-columns: repeat(1, 1fr);
            }
        }
    </style>
</head>
<body>

    <!-- Full-width header -->
    <div class="header">
        <h1>Adopt an Animal</h1>
    </div>

    <div class="content">
        <div class="container">
            <?php
            require_once __DIR__ . '/db_connect.php';

            // Only fetch animals that are NOT deceased
            $sql = "SELECT Animal_ID, Name, Species, Description, Status FROM animals WHERE Status != 'Deceased'";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    $animalName = htmlspecialchars($row['Name']);
                    $animalSpecies = htmlspecialchars($row['Species']);
                    $animalDescription = htmlspecialchars($row['Description']);
                    $animalID = htmlspecialchars($row['Animal_ID']);
                    $status = htmlspecialchars($row['Status']);

                    $imagePath = "images/" . strtolower($animalSpecies) . ".jpg";
                    if (!file_exists($imagePath)) {
                        $imagePath = "images/default.jpg";
                    }
            ?>
                    <div class="card" onclick="flipCard(this)">
                        <div class="card-inner">
                            <div class="card-front">
                                <img src="<?php echo $imagePath; ?>" alt="<?php echo $animalName; ?>">
                                <h3 class="animal-name">
                                    <?php echo $animalName; ?>
                                    <span class="heart" onclick="event.stopPropagation(); toggleHeart(this)">♡</span>
                                </h3>
                                <p class="animal-species"><?php echo $animalSpecies; ?></p>
                                <p class="animal-status">
                                    Status: <?php echo ($status == 'Adopted') ? '<span style="color: red;">Adopted</span>' : '<span style="color: green;">Available</span>'; ?>
                                </p>
                                <a href="adopt_form.php?id=<?php echo $animalID; ?>" class="adopt-btn 
                                   <?php echo ($status == 'Adopted') ? 'adopted' : ''; ?>">
                                   <?php echo ($status == 'Adopted') ? 'Adopted' : 'Adopt'; ?>
                                </a>
                            </div>
                            <div class="card-back">
                                <h3 class="animal-name"><?php echo $animalName; ?></h3>
                                <p class="description"><?php echo $animalDescription; ?></p>
                            </div>
                        </div>
                    </div>
            <?php
                endwhile;
            else:
                echo "<p>No animals available for adoption at the moment.</p>";
            endif;
            $conn->close();
            ?>
        </div>
    </div>

    <footer>
        © 2025 Kanha National Park. All Rights Reserved.
    </footer>

    <script>
        function toggleHeart(element) {
            element.classList.toggle("red");
            element.innerHTML = element.classList.contains("red") ? "❤️" : "♡";
        }

        function flipCard(card) {
            card.classList.toggle("flipped");
        }
    </script>

</body>
</html>
