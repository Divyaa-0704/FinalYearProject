<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt an Animal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Lora:wght@500&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: #f5f5f5; text-align: center; display: flex; flex-direction: column; min-height: 100vh; font-family: 'Poppins', sans-serif; overflow-x: hidden; }
        .header { background-color: rgb(92, 41, 0); width: 100%; padding: 20px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
        .header h1 { color: white; margin: 0; font-family: 'Lora', serif; font-size: 32px; }
        .content { flex: 1; padding: 30px 15px; width: 100%; max-width: 1300px; margin: 0 auto; }
        .container { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; justify-items: center; width: 100%; padding: 10px 0; }
        .card { background: white; border-radius: 12px; perspective: 1000px; width: 100%; max-width: 360px; height: 500px; cursor: pointer; position: relative; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12); }
        .card-inner { position: relative; width: 100%; height: 100%; transform-style: preserve-3d; transition: transform 0.6s; }
        .card.flipped .card-inner { transform: rotateY(180deg); }
        .card-front, .card-back { position: absolute; width: 100%; height: 100%; backface-visibility: hidden; display: flex; flex-direction: column; justify-content: space-between; align-items: center; padding: 16px; border-radius: 12px; box-sizing: border-box; }
        .card-front { background: white; }
        .card-back { background: rgb(92, 41, 0); color: white; transform: rotateY(180deg); text-align: center; padding: 24px; justify-content: center; }
        .card img { width: 100%; height: 260px; border-radius: 10px; object-fit: cover; }
        .animal-name { font-size: 22px; font-weight: bold; margin: 8px 0 4px; font-family: 'Lora', serif; display: flex; justify-content: center; align-items: center; gap: 8px; color: #3d2402; }
        .card-back .animal-name { color: #FFD700; margin-bottom: 12px; }
        .description { font-size: 16px; font-family: 'Poppins', sans-serif; line-height: 1.5; color: #fdfdfd; }
        .heart { cursor: pointer; font-size: 22px; transition: color 0.3s ease; }
        .heart.red { color: red; }
        .animal-species { color: #666; font-size: 15px; margin-bottom: 4px; font-weight: 500; }
        .animal-status { font-size: 15px; font-weight: bold; margin-bottom: 10px; }
        .adopt-btn { background: rgb(155, 86, 3); color: white; border: none; padding: 12px; width: 100%; border-radius: 6px; cursor: pointer; font-size: 17px; font-weight: 600; transition: background 0.3s; text-decoration: none; display: inline-block; text-align: center; }
        .adopt-btn:hover { background: rgb(75, 25, 2); }
        .adopted { background: #888 !important; pointer-events: none; cursor: default; }
        footer { background-color: rgb(92, 41, 0); color: white; text-align: center; padding: 16px; width: 100%; margin-top: auto; position: relative; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Adopt an Animal - Aranya National Park</h1>
    </div>
    <div class="content">
        <div class="container">
            <?php
            require_once __DIR__ . '/db_connect.php';
            $result = false;
            try {
                $sql = "SELECT * FROM animals WHERE (park_id = 2 OR Park_ID = 2) AND Status != 'Deceased'";
                $result = $conn->query($sql);
            } catch (Throwable $e) {
                try {
                    $result = $conn->query("SELECT * FROM animals WHERE Status != 'Deceased'");
                } catch (Throwable $e2) {
                    $result = false;
                }
            }

            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    $animalName = htmlspecialchars($row['Name'] ?? 'Wildlife');
                    $animalSpecies = htmlspecialchars($row['Species'] ?? 'Animal');
                    $animalDescription = htmlspecialchars(!empty($row['Description']) ? $row['Description'] : ($animalName . ' is a wonderful animal in our conservation program.'));
                    $animalID = htmlspecialchars($row['Animal_ID'] ?? $row['id'] ?? '1');
                    $status = htmlspecialchars($row['Status'] ?? 'Present');
                    $imagePath = "images1/" . strtolower($animalSpecies) . ".jpg";
                    if (!file_exists($imagePath)) { $imagePath = "images/default.jpg"; }
            ?>
                    <div class="card" onclick="flipCard(this)">
                        <div class="card-inner">
                            <div class="card-front">
                                <img src="<?php echo $imagePath; ?>" alt="<?php echo $animalName; ?>">
                                <h3 class="animal-name">
                                    <?php echo $animalName; ?>
                                    <span class="heart" onclick="toggleHeart(event, this)">♡</span>
                                </h3>
                                <p class="animal-species"> <?php echo $animalSpecies; ?> </p>
                                <p class="animal-status"> Status: <?php echo ($status == 'Adopted') ? '<span style="color: red;">Adopted</span>' : '<span style="color: green;">Available</span>'; ?> </p>
                                <a href="adopt_form_aranya.php?id=<?php echo $animalID; ?>" class="adopt-btn <?php echo ($status == 'Adopted') ? 'adopted' : ''; ?>"> <?php echo ($status == 'Adopted') ? 'Adopted' : 'Adopt'; ?> </a>
                            </div>
                            <div class="card-back">
                                <h3 class="animal-name"> <?php echo $animalName; ?> </h3>
                                <p class="description"> <?php echo $animalDescription; ?> </p>
                            </div>
                        </div>
                    </div>
            <?php endwhile; else: echo "<p style='grid-column: 1/-1; font-size: 18px; color: #555; padding: 40px;'>No animals available for adoption at the moment.</p>"; endif; $conn->close(); ?>
        </div>
    </div>
    <footer> © 2025 Aranya National Park. All Rights Reserved. </footer>
    <script>
        function toggleHeart(event, element) { event.stopPropagation(); element.classList.toggle("red"); element.innerHTML = element.classList.contains("red") ? "❤️" : "♡"; }
        function flipCard(card) { card.classList.toggle("flipped"); }
    </script>
</body>
</html>
