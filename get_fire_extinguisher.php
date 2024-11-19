<?php
$servername = "localhost";
// $username = "u195589955_fe";
// $password = "P@55w00rdabhik";
$username = "root";
$password = "!QAZzaq1";
$dbname = "u195589955_fe";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['unique_number'])) {
    $unique_number = $_GET['unique_number'];
    $sql = "SELECT * FROM fire_extinguishers WHERE unique_number = '$unique_number'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(["message" => "No fire extinguisher found"]);
    }
}
$conn->close();
?>