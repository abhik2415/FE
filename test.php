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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fire Extinguisher Info</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Fire Extinguisher System</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">View FE Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="insert_fire_extinguisher.php">Add/Update FE Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="report.html">Reports</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="text-center text-primary border border-primary" style="">
        <h1>Reports</h1>
    </div>
    <br />
    <div id="result" class="mt-4">
        <div id="result_alert"></div>
        <!-- Fire extinguisher details will be displayed here -->
    </div>
    <div class="text-center">
        <form
            action=""
            method="get"
            class="row g-3"
            style="display: flex; justify-content: center; align-items: center">
            <div class="col-auto" style="width: 200px">
                <!-- <label for="ReportsDate" class="">Report Date</label> -->
                <input
                    type="date"
                    class="form-control"
                    id="ReportsDate"
                    name="reportDate"
                    required />
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3" id="submitReport">
                    Show Reports
                </button>
            </div>
        </form>
    </div>
    <div class="text-center p-3 mb-2 bg-primary text-white">
        <div>
            <h5>Due Checking Date</h5>
            <div id="detailschecking"></div>
        </div>
        <div>
            <h5>Due Refilling Date</h5>
            <div id="detailsrefilling"></div>
        </div>
        <div>
            <h5>Due Hydraulic Test Date</h5>
            <div id="detailsHydralic"></div>
        </div>
    </div>
</body>
<script>
    document.getElementById("submitReport").addEventListener("click", function() {
        let rptdte = document.getElementById("ReportsDate").value;
        if (rptdte) {
            fetch("reports.php?reportDate=" + rptdte)
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    document.getElementById("detailschecking").innerHTML = data;
                });
        } else {
            document.getElementById("result").innerHTML =
                '<div class="alert alert-danger">Please Enter a Date</div>';
        }
    });
</script>

</html>