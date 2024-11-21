document.getElementById("submitReport").addEventListener("click", function () {
  // toggleDiv();
  var reportDate = document.getElementById("ReportsDate").value;
  if (qrCode) {
    fetch("reports.php?reportDate=" + reportDate)
      .then((response) => response.json())
      .then((data) => {
        if (data.message) {
          document.getElementById("result").innerHTML =
            '<div class="alert alert-danger">FE number is  not present</div>';
        } else {
          // Function to add days to a given date
          function addDays(dateString, days) {
            const date = new Date(dateString);
            date.setDate(date.getDate() + days);
            return date.toISOString().split("T")[0]; // Return formatted date (YYYY-MM-DD)
          }
          // Adding 30 days to the checking date
          // console.log(data.build_date)
          function diffday(dateString) {
            const today = new Date();
            const checkdate = new Date(dateString);
            const diff = today - checkdate; // Calculate the difference in milliseconds
            const differenceInDays = Math.floor(diff / (1000 * 60 * 60 * 24)); // Convert milliseconds to days
            // Check if the difference is negative or positive
            if (differenceInDays < 0) {
              return {
                message: "    Due in " + Math.abs(differenceInDays) + " days",
                className: "due",
              };
            } else {
              return {
                message: "    Overdue by " + differenceInDays + " days",
                className: "overdue",
              };
            }
          }
          let next_checking_date_limit = 90;
          let next_refilling_date_limit = 365;
          let next_hydraulic_test_date_limit = 1095;

          const next_checking_date =
            data.checking_date !== "0000-00-00"
              ? addDays(data.checking_date, next_checking_date_limit)
              : addDays(data.build_date, next_checking_date_limit);
          // console.log(diffday(next_checking_date));
          const next_refilling_date =
            data.refilling_date !== "0000-00-00"
              ? addDays(data.refilling_date, next_refilling_date_limit)
              : addDays(data.build_date, next_refilling_date_limit);
          const next_hydraulic_test_date =
            data.hydraulic_test_date !== "0000-00-00"
              ? addDays(
                  data.hydraulic_test_date,
                  next_hydraulic_test_date_limit
                )
              : addDays(data.build_date, next_hydraulic_test_date_limit);
          if (data.message) {
            document.getElementById("result").innerHTML =
              '<div class="alert alert-danger">' + data.message + "</div>";
          } else {
            document.getElementById("result").innerHTML = `
                                  <div class="card">
                                      <div class="card-header">
                                          Fire Extinguisher Information
                                      </div>
                                      <div class="card-body">
              
                                  <ul class="list-group">
                                      <li class="list-group-item">Coach Number: ${
                                        data.coach_number
                                      }</li>
                                      <li class="list-group-item">Build Date: ${
                                        data.build_date
                                      }</li>
                                      <li class="list-group-item">Checking Date: ${
                                        data.checking_date
                                      }</li>
                                      <li class="list-group-item ${
                                        diffday(next_checking_date).className
                                      }">Next Checking Date due on : ${next_checking_date} ${
              diffday(next_checking_date).message
            }</li>
              
                                      <li class="list-group-item">Refilling Date: ${
                                        data.refilling_date
                                      }</li>
                                      <li class="list-group-item ${
                                        diffday(next_refilling_date).className
                                      }">Next Refilling Date due on : ${next_refilling_date} ${
              diffday(next_refilling_date).message
            }</li>
                                      <li class="list-group-item">Hydraulic Test Date: ${
                                        data.hydraulic_test_date
                                      }</li>
                                      <li class="list-group-item ${
                                        diffday(next_hydraulic_test_date)
                                          .className
                                      }">Next Hydraulic Test Date due on : ${next_hydraulic_test_date} ${
              diffday(next_hydraulic_test_date).message
            }</li>
                                      <li class="list-group-item">Comments : ${
                                        data.status
                                      }</li>
                                  </ul>
                                      </div>
                                  </div>
                              `;
          }
        }
      });
  } else {
    document.getElementById("result").innerHTML =
      '<div class="alert alert-danger">Please Enter or Scan a QR code</div>';
  }
});
