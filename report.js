document.getElementById("submitReport").addEventListener("click", function () {
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
