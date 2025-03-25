<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = ""; // Change if you set a root password
$dbname = "esp_data";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $batteryVoltage = $_POST['batteryVoltage'] ?? null;
    $inputVoltage = $_POST['inputVoltage'] ?? null;
    $inputCurrent = $_POST['inputCurrent'] ?? null;
    $outputVoltage = $_POST['outputVoltage'] ?? null;
    $outputCurrent = $_POST['outputCurrent'] ?? null;
    $temperature = $_POST['temperature'] ?? null;

    if ($batteryVoltage !== null && $inputVoltage !== null) {
        $stmt = $conn->prepare("INSERT INTO sensor_data (batteryVoltage, inputVoltage, inputCurrent, outputVoltage, outputCurrent, temperature) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("dddddd", $batteryVoltage, $inputVoltage, $inputCurrent, $outputVoltage, $outputCurrent, $temperature);
        $stmt->execute();

        echo json_encode(["status" => "success", "data" => $_POST]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid data"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}

$conn->close();
