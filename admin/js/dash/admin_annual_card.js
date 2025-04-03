$(document).ready(function () {
  // Get current year
  var currentDate = new Date();
  var currentYear = currentDate.getFullYear(); // Get full year

  // Set default selected option for year filter
  $("#yearFilter").val(currentYear);

  // Initialize DataTable for the annual table
  var annualTable = $("#annualTable").DataTable({
    bLengthChange: false,
    paging: true,
    info: true,
    searching: false,
    ordering: true,
  });

  // Fetch and populate tables on page load
  fetchAnnualData(currentYear);

  // Update arrival counts on page load
  updateAnnualArrivalCount();

  // Event to open the Annual Tourists Arrival modal
  $("#annualCard").click(function () {
    $("#annualModal").modal("show"); // Show the annual modal
    fetchAnnualData(currentYear); // Populate the table with annual data on modal open
  });

  // Event listener for the year filter in Annual modal
  $("#yearFilter").change(function () {
    fetchAnnualData($(this).val());
  });

  // Function to fetch and populate the Annual Tourists Arrival table
  function fetchAnnualData(year) {
    // Clear existing table data
    annualTable.clear();

    // Construct the URL for fetching annual data
    var url = "../fetch_annual_tourists.php";
    if (year) {
      url += "?year=" + year; // Append year filter if selected
    }

    // AJAX request to fetch annual data
    $.ajax({
      url: url,
      method: "GET",
      dataType: "json",
      success: function (data) {
        if (data.length === 0) {
          // Add a message row if no data is returned
          annualTable.row.add(["No data available", "", "", ""]);
        } else {
          // Populate the table with the returned data
          data.forEach(function (row) {
            annualTable.row.add([
              row.tourist_type,
              row.start_date,
              row.end_date,
            ]);
          });
        }
        annualTable.draw(); // Redraw the table with the new data
      },
      error: function (xhr, status, error) {
        console.error("Error fetching annual data:", status, error);
      },
    });
  }

  // Function to update annual arrival count in the card
  function updateAnnualArrivalCount() {
    $.ajax({
      url: "../fetch_annual_arrival.php",
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#annualCard .h5.mb-0.font-weight-bold.text-gray-800").text(
          data.count
        ); // Update card with count
      },
      error: function (xhr, status, error) {
        console.error("Error fetching annual arrival count:", status, error);
      },
    });
  }
  $("#touristTypeFilter").on("input", function () {
    var filterValue = $(this).val().toLowerCase();
    $("#annualTable tbody tr").each(function () {
      var touristType = $(this).find("td").eq(0).text().toLowerCase();
      // Hide rows that don't match the filter
      if (touristType.indexOf(filterValue) === -1) {
        $(this).hide();
      } else {
        $(this).show();
      }
    });
  });
});
