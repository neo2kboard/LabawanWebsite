$(document).ready(function () {
  // Get current date
  var currentDate = new Date().toISOString().split("T")[0]; // Get current date in YYYY-MM-DD format

  // Set default selected option for date filter
  $("#dateFilter").val(currentDate);

  // Initialize DataTable for the daily table
  var dailyTable = $("#dailyTable").DataTable({
    bLengthChange: false,
    paging: true,
    info: true,
    searching: false,
    ordering: true,
  });

  // Fetch and populate tables on page load
  fetchDailyData(currentDate);

  // Event to open the Daily Tourists Arrival modal
  $("#dailyCard").click(function () {
    $("#dailyModal").modal("show"); // Show the daily modal
    fetchDailyData(currentDate); // Populate the table with daily data on modal open
  });

  // Event listener for the date filter in Daily modal
  $("#dateFilter").change(function () {
    fetchDailyData($(this).val());
  });

  // Function to fetch and populate the Daily Tourists Arrival table
  function fetchDailyData(date) {
    console.log("Fetching data for date: ", date); // Log the selected date
    // Clear existing table data
    dailyTable.clear();

    // Construct the URL for fetching daily data
    var url = "../fetch_daily_tourist.php";
    if (date) {
      url += "?date=" + date; // Append date filter if selected
    }

    // AJAX request to fetch daily data
    $.ajax({
      url: url,
      method: "GET",
      dataType: "json",
      success: function (data) {
        console.log("Fetched data: ", data); // Log fetched data
        if (data.length === 0) {
          // Add a message row if no data is returned
          dailyTable.row.add(["No data available", "", ""]);
        } else {
          // Populate the table with the returned data
          data.forEach(function (row) {
            dailyTable.row.add([
              row.tourist_type, // Tourist type
              row.start_date, // Start date
              row.end_date, // End date
            ]);
          });
        }
        dailyTable.draw(); // Redraw the table with the new data
      },
      error: function (xhr, status, error) {
        console.error("Error fetching daily data:", status, error);
      },
    });
  }

  // Function to update daily arrival count in the card
  function updateDailyArrivalCount() {
    $.ajax({
      url: "../fetch_daily_arrival.php",
      method: "GET",
      dataType: "json",
      success: function (data) {
        console.log("Daily arrival count: ", data.count); // Log the daily arrival count
        $("#dailyCard .h5.mb-0.font-weight-bold.text-gray-800").text(
          data.count
        ); // Update card with count
      },
      error: function (xhr, status, error) {
        console.error("Error fetching daily arrival count:", status, error);
      },
    });
  }

  // Update arrival count on page load
  updateDailyArrivalCount();
});

//FILTER TOURIST TYPE
$(document).ready(function () {
  // Daily Tourists Filter
  $("#dateFilter, #dailyTouristTypeFilter").on("input", function () {
    var dateFilter = $("#dateFilter").val();
    var touristTypeFilter = $("#dailyTouristTypeFilter").val().toLowerCase();

    $("#dailyTable tbody tr").each(function () {
      var touristType = $(this).find("td").eq(0).text().toLowerCase();
      var startDate = $(this).find("td").eq(1).text();

      // Hide row if date or tourist type doesn't match the filter
      if (
        startDate.indexOf(dateFilter) === -1 ||
        touristType.indexOf(touristTypeFilter) === -1
      ) {
        $(this).hide();
      } else {
        $(this).show();
      }
    });
  });
});
