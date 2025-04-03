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
    var url = "fetch_annual_tourists.php";
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
          annualTable.row.add(["No data available", "", ""]);
        } else {
          // Populate the table with the returned data
          data.forEach(function (row) {
            annualTable.row.add([
              row.tourist_type, // Tourist Type
              row.start_date, // Start Date
              row.end_date, // End Date
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
      url: "fetch_annual_arrival.php",
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

  // Update arrival count on page load
  updateAnnualArrivalCount();
});

$(document).ready(function () {
  // When the 'touristType' input changes
  $("#touristType").on("input", function () {
    // Get the entered tourist type
    var touristType = $(this).val();
    // Fetch the data based on the entered tourist type and other filters (like year)
    fetchAnnualData(touristType);
  });

  // Fetch Annual Data function
  function fetchAnnualData(touristType) {
    console.log("Fetching data for tourist type: ", touristType); // Log the tourist type
    var year = $("#yearFilter").val(); // Get the year filter value
    var url = "fetch_annual_tourist.php"; // The PHP script to fetch data

    // If a tourist type is entered, add it to the URL parameters
    if (touristType) {
      url += "?touristType=" + touristType;
    }
    if (year) {
      url += "&year=" + year; // Add the year filter to the URL
    }

    // AJAX request to fetch filtered data
    $.ajax({
      url: url,
      method: "GET",
      dataType: "json",
      success: function (data) {
        console.log("Fetched data: ", data); // Log fetched data

        // Clear existing table data
        $("#annualTable tbody").empty();

        if (data.length === 0) {
          // Add a message row if no data is returned
          $("#annualTable tbody").append(
            '<tr><td colspan="3">No data available</td></tr>'
          );
        } else {
          // Populate the table with the filtered data
          data.forEach(function (row) {
            $("#annualTable tbody").append(
              "<tr><td>" +
                row.tourist_type +
                "</td><td>" +
                row.start_date +
                "</td><td>" +
                row.end_date +
                "</td></tr>"
            );
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("Error fetching data:", status, error);
      },
    });
  }
});

//FILTER TOURIST TYPE
$(document).ready(function () {
  // Listen for the input event on the tourist type filter
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
