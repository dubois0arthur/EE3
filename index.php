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
$result = $conn->query("SELECT batteryVoltage, inputVoltage, inputCurrent, outputVoltage, outputCurrent, temperature, rotation, created_at FROM sensor_data ORDER BY created_at DESC");

echo "<h1>ESP32 MPPT Controller Data Log</h1>";
echo "<table border='1'>";
echo "<tr>
        <th>Battery Voltage (V)</th>
        <th>Input Voltage (V)</th>
        <th>Input Current (A)</th>
        <th>Output Voltage (V)</th>
        <th>Output Current (A)</th>
        <th>Temperature (°C)</th>
        <th>Rotation Status</th>
        <th>Timestamp</th>
      </tr>";

if ($result === false) {
    die("Query failed: " . $conn->error);
}

if ($result->num_rows === 0) {
    echo "<tr><td colspan='7'>No data found in the database.</td></tr>";
}

while ($row = $result->fetch_assoc()) {
    // Convert rotation number to text
    $rotationText = "--";
    if ($row['rotation'] == 0) {
        $rotationText = "Stopped";
    } else if ($row['rotation'] == 1) {
        $rotationText = "Rotating Left";
    } else if ($row['rotation'] == 2) {
        $rotationText = "Rotating Right";
    }

    echo "<tr>
            <td>{$row['batteryVoltage']}</td>
            <td>{$row['inputVoltage']}</td>
            <td>{$row['inputCurrent']}</td>
            <td>{$row['outputVoltage']}</td>
            <td>{$row['outputCurrent']}</td>
            <td>{$row['temperature']}</td>
            <td>{$rotationText}</td>
            <td>{$row['created_at']}</td>
          </tr>";
}

echo "</table>";

$conn->close();

?>

