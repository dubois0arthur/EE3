<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "esp_data";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get POST data
    $batteryVoltage = $_POST['batteryVoltage'] ?? null;
    $inputVoltage = $_POST['inputVoltage'] ?? null;
    $inputCurrent = $_POST['inputCurrent'] ?? null;
    $outputVoltage = $_POST['outputVoltage'] ?? null;
    $outputCurrent = $_POST['outputCurrent'] ?? null;
    $temperature = $_POST['temperature'] ?? null;
    $rotation = $_POST['rotation'] ?? null;


    // Validate all fields are provided
    if ($batteryVoltage !== null && $inputVoltage !== null && $inputCurrent !== null && 
        $outputVoltage !== null && $outputCurrent !== null && $temperature !== null && $rotation !== null) {

        // Sanitize inputs
        $batteryVoltage = filter_var($batteryVoltage, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $inputVoltage = filter_var($inputVoltage, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $inputCurrent = filter_var($inputCurrent, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $outputVoltage = filter_var($outputVoltage, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $outputCurrent = filter_var($outputCurrent, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $temperature = filter_var($temperature, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO sensor_data (batteryVoltage, inputVoltage, inputCurrent, outputVoltage, outputCurrent, temperature, rotation) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ddddddi", $batteryVoltage, $inputVoltage, $inputCurrent, $outputVoltage, $outputCurrent, $temperature, $rotation);

        if ($stmt->execute()) {
            $id = $stmt->insert_id;
            echo json_encode([
                "status" => "success",
                "id" => $id,
                "data" => [
                    "batteryVoltage" => $batteryVoltage,
                    "inputVoltage" => $inputVoltage,
                    "inputCurrent" => $inputCurrent,
                    "outputVoltage" => $outputVoltage,
                    "outputCurrent" => $outputCurrent,
                    "temperature" => $temperature,
                    "rotation" => $rotation
                ]
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Insert failed: " . $stmt->error]);
        }

        $stmt->close();

    } else {
        echo json_encode(["status" => "error", "message" => "Invalid data"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}

$conn->close();