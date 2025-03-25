<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "esp_data";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the table
$result = $conn->query("SELECT value, created_at FROM sensor_data ORDER BY created_at DESC");

echo "<h1>ESP32 Data Log</h1>";
echo "<table border='1'>";
echo "<tr><th>Value</th><th>Timestamp</th></tr>";

if ($result === false) {
    die("Query failed: " . $conn->error);
}
if ($result->num_rows === 0) {
    die("No data found in the database.");
}


while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['value']}</td><td>{$row['created_at']}</td></tr>";
}

echo "</table>";

$conn->close();
