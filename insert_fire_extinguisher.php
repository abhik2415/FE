<?php
// Database connection
$servername = "localhost";
$username = "u195589955_fe";
$username = "root";
// $password = "P@55w00rdabhik";
$password = "!QAZzaq1";
$dbname = "u195589955_fe";
$flag=true;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = ""; // Initialize the message variable

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// if (isset($_POST['submit'])) {
    // Retrieve form data
    $action = $_POST['action']; // Retrieve the button clicked
    $unique_number = $_POST['unique_number'];
    $coach_number = $_POST['coach_number'];
    $build_date = $_POST['build_date'];
    $checking_date = $_POST['checking_date'];
    $refilling_date = $_POST['refilling_date'];
    $hydraulic_test_date = $_POST['hydraulic_test_date'];
    $status = $_POST['status'];


    // print ("checking date value is ". $refilling_date);
    // print ("refilling date value is ". $refilling_date);
    // print ("hydralic date value is ". $hydraulic_test_date);
    if ($action === 'submit') 
    {
      // if (isset($checking_date))
      // {
      //   if($checking_date<$build_date)
      //   {
      //     print ("checking_date is ". isset($checking_date));
      //     $successMessage  = "<strong>Error</strong> in Checking date";
      //     $flag=false;
      //     // return;
      //   }
      // }
      // if (isset($refilling_date))
      // {
      //   if( $refilling_date<$build_date )
      //   {
      //     print ("refilling is ". isset($refilling_date));
      //     $successMessage  = "<strong>Error</strong> in refilling date";
      //     $flag=false;
      //     // return;
      //   }
      // }
      // if (isset($hydraulic_test_date))
      // {
      //   if($hydraulic_test_date<$build_date)
      //   {
      //     print ("hydralic date is ". isset($hydraulic_test_date));
      //     $successMessage  = "<strong>Error</strong> in hydralic test date";
      //     $flag=false;
      //     // return;
      //   }
      // }
      // if($flag)
      // {
        // Check if the unique number already exists
    $check_sql = "SELECT * FROM fire_extinguishers WHERE unique_number = '$unique_number'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // Update the existing record
        $update_sql = "UPDATE fire_extinguishers 
                       SET coach_number='$coach_number', build_date='$build_date', checking_date='$checking_date',
                           refilling_date='$refilling_date', hydraulic_test_date='$hydraulic_test_date', status='$status'
                       WHERE unique_number='$unique_number'";

        if ($conn->query($update_sql) === TRUE) {
            $successMessage  = "Record for Fire Extinguisher with Unique Number <strong>$unique_number</strong> has been successfully <strong>updated</strong>.";
        } else {
            $successMessage  = "Error updating record: " . $conn->error;
        }
    } else {
        // Insert a new record
        $insert_sql = "INSERT INTO fire_extinguishers (unique_number, coach_number, build_date, checking_date, refilling_date, hydraulic_test_date, status)
                       VALUES ('$unique_number', '$coach_number', '$build_date', '$checking_date', '$refilling_date', '$hydraulic_test_date', '$status')";

        if ($conn->query($insert_sql) === TRUE) {
            $successMessage  = "New Fire Extinguisher record with Unique Number <strong>$unique_number</strong> has been successfully <strong>added</strong>.";
        } else {
            $successMessage  = "Error inserting new record: " . $conn->error;
        }
    }
      }

    // } 
    
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Fire Extinguisher</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
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
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="index.html">View FE Details</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="insert_fire_extinguisher.php"
                >Add/Update FE Details</a
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container mt-5">
      <h1>Add / Update Fire Extinguisher Details</h1>
      <div id="result"></div>
      <!-- Display success or error message -->
      <?php if ($successMessage != ""): ?>
      <div class="alert alert-success">
        <?php echo $successMessage; ?>
      </div>
      <?php endif; ?>

      <form action="" method="POST">
        <div class="form-row">
          <div class="col-md-6">
            <label for="uniqueNumber" class="form-label"
              >FE Number</label
            >
          </div>
          <div class="col">
            <input
              type="text"
              class="form-control"
              id="uniqueNumber"
              name="unique_number"
              required
              value="<?php echo isset($_POST['unique_number']) ? '' : ''; ?>"
            />
          </div>
          <div class="col">
            <button
              type="submit"
              class="flex-lg-nowrap btn btn-primary"
              id="fetchData" 
              name="action"
            >
              Fetch Details
            </button>
          </div>
        </div>
        <div class="mb-3">
          <label for="coachNumber" class="form-label">Coach Number</label>
          <input
            type="text"
            class="form-control"
            id="coachNumber"
            name="coach_number"
            value="<?php echo isset($_POST['coach_number']) ? '' : ''; ?>"
          />
        </div>
        <div class="mb-3">
          <label for="buildDate" class="form-label">Build Date</label>
          <input
            type="date"
            class="form-control"
            id="buildDate"
            name="build_date"
            required
            value="<?php echo isset($_POST['build_date']) ? '' : ''; ?>"
          />
        </div>
        <div class="mb-3">
          <label for="checkingDate" class="form-label">Checking Date</label>
          <input
            type="date"
            class="form-control"
            id="checkingDate"
            name="checking_date"
            value="<?php echo isset($_POST['checking_date']) ? '' : ''; ?>"
          />
        </div>
        <div class="mb-3">
          <label for="refillingDate" class="form-label">Refilling Date</label>
          <input
            type="date"
            class="form-control"
            id="refillingDate"
            name="refilling_date"
            value="<?php echo isset($_POST['refilling_date']) ? '' : ''; ?>"
          />
        </div>
        <div class="mb-3">
          <label for="hydraulicTestDate" class="form-label"
            >Hydraulic Test Date</label
          >
          <input
            type="date"
            class="form-control"
            id="hydraulicTestDate"
            name="hydraulic_test_date"
            value="<?php echo isset($_POST['hydraulic_test_date']) ? '' : ''; ?>"
          />
        </div>
        <div class="mb-3">
          <label for="status" class="form-label">Comments</label>
          <input
            type="text"
            class="form-control"
            id="status"
            name="status"
            value="<?php echo isset($_POST['status']) ? '' : ''; ?>"
          />
        </div>
        <button type="submit" class="btn btn-primary" id="submitData" name="action" value="submit">
          Submit
        </button>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="fetch.js"></script>
  </body>
</html>
