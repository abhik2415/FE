// document.getElementById("submitReport").addEventListener("click", function () {
//   let rptdte = document.getElementById("ReportsDate").value;
//   if (rptdte) {
//     fetch("reports.php?reportDate=" + rptdte)
//       .then((response) => response.json())
//       .then((data) => {
//         console.log(data);
//         document.getElementById("detailschecking").innerHTML = data;
//       });
//   } else {
//     document.getElementById("result").innerHTML =
//       '<div class="alert alert-danger">Please Enter a Date</div>';
//   }
// });

document
  .getElementById("submitReport")
  .addEventListener("click", function (event) {
    event.preventDefault();
    let rptdte = document.getElementById("ReportsDate").value;
    if (rptdte) {
      fetch("reports.php?reportDate=" + rptdte)
        .then((response) => response.json())
        .then((data) => {
          document.getElementById("detailschecking").innerHTML = generateTable(
            data.sql_checking_date,
            "checking"
          );
          document.getElementById("detailsrefilling").innerHTML = generateTable(
            data.sql_refilling_date,
            "refilling"
          );
          document.getElementById("detailsHydralic").innerHTML = generateTable(
            data.sql_hydraulic_test_date,
            "hydralic"
          );
        })
        .catch((error) => {
          console.error(error);
          document.getElementById("result").innerHTML =
            '<div class="alert alert-danger">Error loading data</div>';
        });
    } else {
      document.getElementById("result").innerHTML =
        '<div class="alert alert-danger">Please Enter a Date</div>';
    }
  });

function generateTable(data, datetype) {
  if (data.length === 0) return "<p>No records found</p>";
  if (datetype == "checking") {
    let table = `<table class="table"><thead><tr><th>FE Number</th><th>Train Number</th><th>Coach Number</th><th>Build Date</th><th>Last Checking Date</th><th>Next Checking Date</th><th>Day\'s Pending</th></tr></thead><tbody>`;
    data.forEach((row) => {
      table += `<tr>
          <td>${row.unique_number}</td>
          <td>${row.Train_No || ""}</td>
          <td>${row.coach_number}</td>
          <td>${row.build_date}</td>
          <td>${(row.checking_date = "0000 - 00 - 00"
            ? ""
            : row.checking_date)}</td>
          <td>${row.next_checking_date}</td>
          <td>${row.day_difference}</td>
      </tr>`;
    });
    table += `</tbody></table>`;
    return table;
  }

  if (datetype == "refilling") {
    let table = `<table class="table"><thead><tr><th>FE Number</th><th>Train Number</th><th>Coach Number</th><th>Build Date</th><th>Last refilling Date</th><th>Next refilling Date</th><th>Day\'s Pending</th></tr></thead><tbody>`;
    data.forEach((row) => {
      table += `<tr>
          <td>${row.unique_number}</td>
          <td>${row.Train_No || ""}</td>
          <td>${row.coach_number}</td>
          <td>${row.build_date}</td>
          <td>${(row.refilling_date = "0000 - 00 - 00"
            ? ""
            : row.refilling_date)}</td>
          <td>${row.next_refilling_date}</td>
          <td>${row.day_difference}</td>
      </tr>`;
    });
    table += `</tbody></table>`;
    return table;
  }

  if (datetype == "hydralic") {
    let table = `<table class="table"><thead><tr><th>FE Number</th><th>Train Number</th><th>Coach Number</th><th>Build Date</th><th>Last hydralic Date</th><th>Next hydralic Date</th><th>Day\'s Pending</th></tr></thead><tbody>`;
    data.forEach((row) => {
      table += `<tr>
          <td>${row.unique_number}</td>
          <td>${row.Train_No || ""}</td>
          <td>${row.coach_number}</td>
          <td>${row.build_date}</td>
          <td>${(row.hydraulic_test_date = "0000 - 00 - 00"
            ? ""
            : row.hydraulic_test_date)}</td>
          <td>${row.next_hydraulic_test_date}</td>
          <td>${row.day_difference}</td>
      </tr>`;
    });
    table += `</tbody></table>`;
    return table;
  }
}
