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

    $sql_checking_date = "SELECT unique_number,coach_number,checking_date,
    CASE 
        WHEN checking_date != '0000-00-00' THEN DATE_ADD(checking_date, INTERVAL 90 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 90 DAY)
    END AS next_checking_date,
    DATEDIFF(CURRENT_DATE(), (CASE 
        WHEN checking_date != '0000-00-00' THEN DATE_ADD(checking_date, INTERVAL 90 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 90 DAY)
    END)) AS day_difference
FROM `fire_extinguishers`
WHERE 
    (CASE 
        WHEN checking_date != '0000-00-00' THEN DATE_ADD(checking_date, INTERVAL 90 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 90 DAY)
    END) <= '$reportDate'
    ORDER by  day_difference DESC ;";
    $result_checking_date = $conn->query($sql_checking_date);




    // --------------------------------------------------------------------------- 
    $sql_refilling_date = "SELECT unique_number,coach_number,refilling_date,
        CASE 
            WHEN refilling_date != '0000-00-00' THEN DATE_ADD(refilling_date, INTERVAL 365 DAY)
            ELSE DATE_ADD(build_date, INTERVAL 365 DAY)
        END AS next_refilling_date,
        DATEDIFF(CURRENT_DATE(), (CASE 
            WHEN refilling_date != '0000-00-00' THEN DATE_ADD(refilling_date, INTERVAL 365 DAY)
            ELSE DATE_ADD(build_date, INTERVAL 365 DAY)
        END)) AS day_difference
    FROM `fire_extinguishers`
    WHERE 
        (CASE 
            WHEN refilling_date != '0000-00-00' THEN DATE_ADD(refilling_date, INTERVAL 365 DAY)
            ELSE DATE_ADD(build_date, INTERVAL 365 DAY)
        END) <= '$reportDate'
        ORDER by  day_difference DESC ;";
    $result_refilling_date = $conn->query($sql_refilling_date);


    // ----------------------------------------------------------------------------------------------

    $sql_hydraulic_test_date = "SELECT unique_number,coach_number,hydraulic_test_date,
    CASE 
        WHEN hydraulic_test_date != '0000-00-00' THEN DATE_ADD(hydraulic_test_date, INTERVAL 1095 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 1095 DAY)
    END AS next_hydraulic_test_date,
    DATEDIFF(CURRENT_DATE(), (CASE 
        WHEN hydraulic_test_date != '0000-00-00' THEN DATE_ADD(hydraulic_test_date, INTERVAL 1095 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 1095 DAY)
    END)) AS day_difference
FROM `fire_extinguishers`
WHERE 
    (CASE 
        WHEN hydraulic_test_date != '0000-00-00' THEN DATE_ADD(hydraulic_test_date, INTERVAL 1095 DAY)
        ELSE DATE_ADD(build_date, INTERVAL 1095 DAY)
    END) <= '$reportDate'
    ORDER by  day_difference DESC ;";
    $result_hydraulic_test_date = $conn->query($sql_hydraulic_test_date);
}
$conn->close();


echo '    <table>
        <thead>
            <tr>
                <th>FE Number</th>
                <th>Checking Date</th>
                <th>Next Checking Date</th>
                <th>Day\'s Pending</th>
            </tr>
        </thead>
        <tbody>';

if ($result_checking_date->num_rows > 0) {
    // Output each row
    while ($row = $result_checking_date->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["unique_number"] . "</td>";
        echo "<td>" . $row["checking_date"] . "</td>";
        echo "<td>" . $row["next_checking_date"] . "</td>";
        echo "<td>" . $row["day_difference"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No records found</td></tr>";
}
echo '
 </tbody>
    </table>
';
