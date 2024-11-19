document.getElementById("uniqueNumber").value = "";
document.getElementById("coachNumber").value = "";
document.getElementById("buildDate").value = "";
document.getElementById("checkingDate").value = "";
document.getElementById("refillingDate").value = "";
document.getElementById("hydraulicTestDate").value = "";
document.getElementById("status").value = "";

document.getElementById("fetchData").addEventListener("click", function () {
  // toggleDiv();
  var qrCode = document.getElementById("uniqueNumber").value;
  if (qrCode) {
    fetch("get_fire_extinguisher.php?unique_number=" + qrCode)
      .then((response) => response.json())
      .then((data) => {
        if (data.message) {
          let successMessage = ""; // Initialize the message variable
          document.getElementById("result").innerHTML =
            '<div class="alert alert-danger">FE number is  not present</div>';
        } else {
          document.getElementById("coachNumber").value = data.coach_number;
          document.getElementById("buildDate").value = data.build_date;
          document.getElementById("buildDate").readOnly = true;
          document.getElementById("checkingDate").value = data.checking_date;
          document.getElementById("refillingDate").value = data.refilling_date;
          document.getElementById("hydraulicTestDate").value =
            data.hydraulic_test_date;
          document.getElementById("status").value = data.status;
        }
      });
  } else {
    document.getElementById("result").innerHTML =
      '<div class="alert alert-danger">Please Enter a FE Number</div>';
  }
});
