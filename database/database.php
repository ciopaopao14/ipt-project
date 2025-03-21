<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ipt2_midterm_project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to reset ID to 0 when table is empty
function resetIdIfEmpty($tableName, $connection) {
    $query = "SELECT COUNT(*) as count FROM $tableName";
    $result = $connection->query($query);
    $row = $result->fetch_assoc();
    if ($row['count'] == 0) {
        $query = "ALTER TABLE $tableName AUTO_INCREMENT = 1";
        $connection->query($query);
    }
}

// Example usage
resetIdIfEmpty('musics', $conn);

$sql = "SELECT * FROM musics ORDER BY ID ASC";
$counter = 1;
?>