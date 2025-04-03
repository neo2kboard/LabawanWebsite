$(document).ready(function () {
  // Get current month
  var currentDate = new Date();
  var currentMonth = ("0" + (currentDate.getMonth() + 1)).slice(-2); // Get month in MM format

  // Set default selected option for month filter
  $("#monthFilter").val(currentMonth);

  // Initialize DataTable for the monthly table
  var modalTable = $("#modalTable").DataTable({
    bLengthChange: false,
    paging: true,
    info: true,
    searching: false,
    ordering: true,
  });

  // Fetch and populate tables on page load
  fetchMonthlyData(currentMonth);

  // Event to open the Monthly Tourists Arrival modal
  $("#monthlyCard").click(function () {
    $("#infoModal").modal("show"); // Show the monthly modal
    fetchMonthlyData(currentMonth); // Populate the table with monthly data on modal open
  });

  // Event listener for the month filter in Monthly modal
  $("#monthFilter").change(function () {
    fetchMonthlyData($(this).val());
  });

  // Function to fetch and populate the Monthly Tourists Arrival table
  function fetchMonthlyData(month) {
    // Clear existing table data
    modalTable.clear();

    // Construct the URL for fetching monthly data
    var url = "fetch_monthly_tourists.php";
    if (month) {
      url += "?month=" + month; // Append month filter if selected
    }

    // AJAX request to fetch monthly data
    $.ajax({
      url: url,
      method: "GET",
      dataType: "json",
      success: function (data) {
        if (data.length === 0) {
          // Add a message row if no data is returned
          modalTable.row.add(["No data available", "", ""]);
        } else {
          // Populate the table with the returned data
          data.forEach(function (row) {
            modalTable.row.add([
              row.tourist_type, // Tourist Type
              row.start_date, // Start Date
              row.end_date, // End Date
            ]);
          });
        }
        modalTable.draw(); // Redraw the table with the new data
      },
      error: function (xhr, status, error) {
        console.error("Error fetching monthly data:", status, error);
      },
    });
  }

  // Function to update monthly arrival count in the card
  function updateMonthlyArrivalCount() {
    $.ajax({
      url: "fetch_monthly_arrival.php",
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#monthlyCard .h5.mb-0.font-weight-bold.text-gray-800").text(
          data.count
        ); // Update card with count
      },
      error: function (xhr, status, error) {
        console.error("Error fetching monthly arrival count:", status, error);
      },
    });
  }

  // Update arrival count on page load
  updateMonthlyArrivalCount();
});

//FILTER TOURIST TYPE
$(document).ready(function () {
  // Monthly Tourists Filter
  $("#monthFilter, #monthTouristTypeFilter").on("input", function () {
    var monthFilter = $("#monthFilter").val();
    var touristTypeFilter = $("#monthTouristTypeFilter").val().toLowerCase();

    $("#modalTable tbody tr").each(function () {
      var touristType = $(this).find("td").eq(0).text().toLowerCase();
      var startDate = $(this).find("td").eq(1).text();
      var month = startDate.substring(5, 7); // Extract month from 'YYYY-MM-DD' format

      // Hide row if month or tourist type doesn't match the filter
      if (
        month.indexOf(monthFilter) === -1 ||
        touristType.indexOf(touristTypeFilter) === -1
      ) {
        $(this).hide();
      } else {
        $(this).show();
      }
    });
  });
});
