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

if (isset($_GET['reportDate'])) {
    $reportDate = $_GET['reportDate'];
    $sql = "SELECT unique_number,coach_number,hydraulic_test_date,
    CASE 
        WHEN hydraulic_test_date != '0000-00-00' THEN DATE_ADD(hydraulic_test_date, INTERVAL 1095 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 1095 DAY)
    END AS next_hydraulic_test_date
FROM `fire_extinguishers`
WHERE 
    (CASE 
        WHEN hydraulic_test_date != '0000-00-00' THEN DATE_ADD(hydraulic_test_date, INTERVAL 1095 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 1095 DAY)
    END) <= '$reportDate';";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(["message" => "No Report found"]);
    }
}
$conn->close();
?>