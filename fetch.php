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

?>