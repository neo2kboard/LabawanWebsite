<script>
$(document).ready(function () {
    // Get current month and year
    var currentDate = new Date();
    var currentMonth = ("0" + (currentDate.getMonth() + 1)).slice(-2); // Get month in MM format
    var currentYear = currentDate.getFullYear(); // Get full year

    // Set default selected option for month and year filters
    $('#monthFilter').val(currentMonth);
    $('#yearFilter').val(currentYear);

    // Initialize DataTable for the monthly table
    var modalTable = $('#modalTable').DataTable({
        "bLengthChange": false,
        "paging": true,
        "info": true,
        "searching": false,
        "ordering": true
    });

    // Initialize DataTable for the annual table
    var annualTable = $('#annualTable').DataTable({
        "bLengthChange": false,
        "paging": true,
        "info": true,
        "searching": false,
        "ordering": true
    });

    // Fetch and populate tables on page load
    fetchMonthlyData(currentMonth);
    fetchAnnualData(currentYear);

    // Update arrival counts on page load
    updateMonthlyArrivalCount();
    updateAnnualArrivalCount();

    // Event to open the Monthly Tourists Arrival modal
    $('#monthlyCard').click(function () {
        $('#infoModal').modal('show'); // Show the monthly modal
        fetchMonthlyData(currentMonth); // Populate the table with monthly data on modal open
    });

    // Event listener for the month filter in Monthly modal
    $('#monthFilter').change(function () {
        fetchMonthlyData($(this).val());
    });

    // Event to open the Annual Tourists Arrival modal
    $('#annualCard').click(function () {
        $('#annualModal').modal('show'); // Show the annual modal
        fetchAnnualData(currentYear); // Populate the table with annual data on modal open
    });

    // Event listener for the year filter in Annual modal
    $('#yearFilter').change(function () {
        fetchAnnualData($(this).val());
    });

    // Function to fetch and populate the Monthly Tourists Arrival table
    function fetchMonthlyData(month) {
        // Clear existing table data
        modalTable.clear();

        // Construct the URL for fetching monthly data
        var url = '../fetch_monthly_tourists.php';
        if (month) {
            url += '?month=' + month; // Append month filter if selected
        }

        // AJAX request to fetch monthly data
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.length === 0) {
                    // Add a message row if no data is returned
                    modalTable.row.add(['No data available', '', '', '']);
                } else {
                    // Populate the table with the returned data
                    data.forEach(function (row) {
                        modalTable.row.add([row.name, row.tourist_type, row.start_date, row.end_date]);
                    });
                }
                modalTable.draw(); // Redraw the table with the new data
            },
            error: function (xhr, status, error) {
                console.error('Error fetching monthly data:', status, error);
            }
        });
    }

    // Function to fetch and populate the Annual Tourists Arrival table
    function fetchAnnualData(year) {
        // Clear existing table data
        annualTable.clear();

        // Construct the URL for fetching annual data
        var url = '../fetch_annual_tourists.php';
        if (year) {
            url += '?year=' + year; // Append year filter if selected
        }

        // AJAX request to fetch annual data
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.length === 0) {
                    // Add a message row if no data is returned
                    annualTable.row.add(['No data available', '', '', '']);
                } else {
                    // Populate the table with the returned data
                    data.forEach(function (row) {
                        annualTable.row.add([row.name, row.tourist_type, row.start_date, row.end_date]);
                    });
                }
                annualTable.draw(); // Redraw the table with the new data
            },
            error: function (xhr, status, error) {
                console.error('Error fetching annual data:', status, error);
            }
        });
    }

    // Function to update monthly arrival count in the card
    function updateMonthlyArrivalCount() {
        $.ajax({
            url: '../fetch_monthly_arrival.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#monthlyCard .h5.mb-0.font-weight-bold.text-gray-800').text(data.count); // Update card with count
            },
            error: function (xhr, status, error) {
                console.error('Error fetching monthly arrival count:', status, error);
            }
        });
    }

    // Function to update annual arrival count in the card
    function updateAnnualArrivalCount() {
        $.ajax({
            url: '../fetch_annual_arrival.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#annualCard .h5.mb-0.font-weight-bold.text-gray-800').text(data.count); // Update card with count
            },
            error: function (xhr, status, error) {
                console.error('Error fetching annual arrival count:', status, error);
            }
        });
    }
});
</script>

<script>
    $(document).ready(function () {
    // Get current date
    var currentDate = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format

    // Set default selected option for date filter
    $('#dateFilter').val(currentDate);

    // Initialize DataTable for the daily table
    var dailyTable = $('#dailyTable').DataTable({
        "bLengthChange": false,
        "paging": true,
        "info": true,
        "searching": false,
        "ordering": true
    });

    // Fetch and populate tables on page load
    fetchDailyData(currentDate);

    // Event to open the Daily Tourists Arrival modal
    $('#dailyCard').click(function () {
        $('#dailyModal').modal('show'); // Show the daily modal
        fetchDailyData(currentDate); // Populate the table with daily data on modal open
    });

    // Event listener for the date filter in Daily modal
    $('#dateFilter').change(function () {
        fetchDailyData($(this).val());
    });

    // Function to fetch and populate the Daily Tourists Arrival table
    function fetchDailyData(date) {
        console.log("Fetching data for date: ", date); // Log the selected date
        // Clear existing table data
        dailyTable.clear();

        // Construct the URL for fetching daily data
        var url = '../fetch_daily_tourist.php';
        if (date) {
            url += '?date=' + date; // Append date filter if selected
        }

        // AJAX request to fetch daily data
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log("Fetched data: ", data); // Log fetched data
                if (data.length === 0) {
                    // Add a message row if no data is returned
                    dailyTable.row.add(['No data available', '', '', '']);
                } else {
                    // Populate the table with the returned data
                    data.forEach(function (row) {
                        dailyTable.row.add([row.name, row.tourist_type, row.start_date, row.end_date]);
                    });
                }
                dailyTable.draw(); // Redraw the table with the new data
            },
            error: function (xhr, status, error) {
                console.error('Error fetching daily data:', status, error);
            }
        });
    }

    // Function to update daily arrival count in the card
    function updateDailyArrivalCount() {
        $.ajax({
            url: '../fetch_daily_arrival.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log("Daily arrival count: ", data.count); // Log the daily arrival count
                $('#dailyCard .h5.mb-0.font-weight-bold.text-gray-800').text(data.count); // Update card with count
            },
            error: function (xhr, status, error) {
                console.error('Error fetching daily arrival count:', status, error);
            }
        });
    }

    // Update arrival count on page load
    updateDailyArrivalCount();
});
</script>

<script>
    $(document).ready(function () {
    // Define colors for different tourist types
    const colors = {
        'Local Mabini': 'bg-info',
        'Local Bohol': 'bg-primary',
        'International Asia': 'bg-danger',
        'Regional Cebu': 'bg-warning',
        'Regional Manila': 'bg-warning',
        'Foreign': 'bg-danger'
    };

    // Function to fetch tourist distribution
    function fetchTouristDistribution() {
        $.ajax({
            url: '../fetch_tourist_distribution.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log("Tourist distribution: ", data); // Log the distribution data

                // Clear existing progress bars
                $('#touristDistribution').empty();

                // Add new progress bars
                data.forEach(function (dist) {
                    const colorClass = colors[dist.tourist_type] || 'bg-secondary'; // Default color if no match found
                    var progressBarHtml = `
                        <h4 class="small font-weight-bold">${dist.tourist_type} <span class="float-right">${dist.percentage.toFixed(2)}%</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar ${colorClass}" role="progressbar" style="width: ${dist.percentage}%" aria-valuenow="${dist.percentage}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    `;
                    $('#touristDistribution').append(progressBarHtml);
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching tourist distribution:', status, error);
            }
        });
    }

    // Fetch tourist distribution on page load
    fetchTouristDistribution();
});
</script>

<script>
    

$(document).ready(function () {
    // Function to fetch tourist arrivals and update the chart
    function fetchTouristArrivals() {
        $.ajax({
            url: '../fetch_area_chart.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log("Tourist arrivals: ", data); // Log the arrivals data

                // Prepare data for the chart
                const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                const counts = Object.values(data);

                // Create the chart
                const ctx = document.getElementById('myAreaChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Tourist Arrivals',
                            data: counts,
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            x: {
                                time: {
                                    unit: 'month'
                                },
                                grid: {
                                    display: false,
                                    drawBorder: false
                                }
                            },
                            y: {
                                ticks: {
                                    beginAtZero: true,
                                    max: 100
                                },
                                grid: {
                                    color: 'rgb(234, 236, 244)',
                                    zeroLineColor: 'rgb(234, 236, 244)',
                                    drawBorder: false
                                }
                            }
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: 'rgb(255, 255, 255)',
                            bodyColor: '#858796',
                            titleColor: '#6e707e',
                            borderColor: '#dddfeb',
                            borderWidth: 1
                        }
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching tourist arrivals:', status, error);
            }
        });
    }

    // Fetch tourist arrivals on page load
    fetchTouristArrivals();
});

</script>