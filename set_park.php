<?php
session_start();

error_log(print_r($_POST, true)); // Log received POST data

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["selectedPark"])) {
    $_SESSION["selected_park"] = $_POST["selectedPark"];
    echo json_encode(["success" => true, "park" => $_SESSION["selected_park"]]);
} else {
    echo json_encode(["success" => false, "error" => "No park selected"]);
}
?>
