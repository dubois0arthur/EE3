<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "esp_data";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

$result = $conn->query("SELECT * FROM sensor_data ORDER BY created_at DESC LIMIT 1");

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["status" => "error", "message" => "No data found"]);
}

$conn->close();

/*

// Simulate random data for testing
header('Content-Type: application/json');

// Generate random values for testing
$data = [
    "batteryVoltage" => rand(10, 15) + rand(0, 99) / 100, // Random voltage between 10.00 and 15.99
    "inputVoltage" => rand(20, 25) + rand(0, 99) / 100,   // Random voltage between 20.00 and 25.99
    "inputCurrent" => rand(1, 10) + rand(0, 99) / 100,    // Random current between 1.00 and 10.99
    "outputVoltage" => rand(10, 15) + rand(0, 99) / 100,  // Random voltage between 10.00 and 15.99
    "outputCurrent" => rand(1, 10) + rand(0, 99) / 100,   // Random current between 1.00 and 10.99
    "temperature" => rand(20, 40) + rand(0, 99) / 100     // Random temperature between 20.00 and 40.99
];

// Return the random data as JSON
echo json_encode($data); */
?>