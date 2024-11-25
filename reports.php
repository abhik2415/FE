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
    header('Content-Type: application/json');
    // $reportDate = $_GET['reportDate'];
    $reportDate = $conn->real_escape_string($_GET['reportDate']);

    $queries = [

        'sql_checking_date' => "SELECT unique_number,coach_number,build_date,checking_date,
        CASE 
            WHEN checking_date != '0000-00-00' THEN DATE_ADD(checking_date, INTERVAL 90 DAY)
            ELSE DATE_ADD(build_date, INTERVAL 90 DAY)
        END AS next_checking_date,
        DATEDIFF('$reportDate', (CASE 
            WHEN checking_date != '0000-00-00' THEN DATE_ADD(checking_date, INTERVAL 90 DAY)
            ELSE DATE_ADD(build_date, INTERVAL 90 DAY)
        END)) AS day_difference
        FROM `fire_extinguishers`
        WHERE 
        (CASE 
            WHEN checking_date != '0000-00-00' THEN DATE_ADD(checking_date, INTERVAL 90 DAY)
            ELSE DATE_ADD(build_date, INTERVAL 90 DAY)
        END) <= '$reportDate'
        ORDER by  day_difference DESC",
        // $result_checking_date = $conn->query($sql_checking_date);




        // --------------------------------------------------------------------------- 
        'sql_refilling_date' => "SELECT unique_number,coach_number, build_date, refilling_date,
            CASE 
                WHEN refilling_date != '0000-00-00' THEN DATE_ADD(refilling_date, INTERVAL 365 DAY)
                ELSE DATE_ADD(build_date, INTERVAL 365 DAY)
            END AS next_refilling_date,
            DATEDIFF('$reportDate', (CASE 
                WHEN refilling_date != '0000-00-00' THEN DATE_ADD(refilling_date, INTERVAL 365 DAY)
                ELSE DATE_ADD(build_date, INTERVAL 365 DAY)
            END)) AS day_difference
        FROM `fire_extinguishers`
        WHERE 
            (CASE 
                WHEN refilling_date != '0000-00-00' THEN DATE_ADD(refilling_date, INTERVAL 365 DAY)
                ELSE DATE_ADD(build_date, INTERVAL 365 DAY)
            END) <= '$reportDate' 
            ORDER by  day_difference DESC",
        // $result_refilling_date = $conn->query($sql_refilling_date);


        // ----------------------------------------------------------------------------------------------

        'sql_hydraulic_test_date' => "SELECT unique_number,coach_number, build_date, hydraulic_test_date,
        CASE 
            WHEN hydraulic_test_date != '0000-00-00' THEN DATE_ADD(hydraulic_test_date, INTERVAL 1095 DAY)
            ELSE DATE_ADD(build_date, INTERVAL 1095 DAY)
        END AS next_hydraulic_test_date,
        DATEDIFF('$reportDate', (CASE 
            WHEN hydraulic_test_date != '0000-00-00' THEN DATE_ADD(hydraulic_test_date, INTERVAL 1095 DAY)
            ELSE DATE_ADD(build_date, INTERVAL 1095 DAY)
        END)) AS day_difference
        FROM `fire_extinguishers`
        WHERE 
        (CASE 
            WHEN hydraulic_test_date != '0000-00-00' THEN DATE_ADD(hydraulic_test_date, INTERVAL 1095 DAY)
            ELSE DATE_ADD(build_date, INTERVAL 1095 DAY)
        END) <= '$reportDate'
        ORDER by  day_difference DESC",
    ];
    // $result_hydraulic_test_date = $conn->query($sql_hydraulic_test_date);
    $results = [];
    foreach ($queries as $key => $query) {
        $res = $conn->query($query);
        $results[$key] = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    echo json_encode($results);
}
$conn->close();
exit();
