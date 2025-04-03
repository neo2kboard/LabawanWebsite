<?php
    include('../security.php');
    include('includes/header.php'); 
    include('includes/navbar_ta.php'); 
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <?php include('includes/topbar.php'); ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-2 text-gray-800">Reports > Total Tourist Arrival</h1>
                
                <a href="../generate_report.php?date_range=<?php echo isset($_GET['date_range']) ? $_GET['date_range'] : 'daily'; ?>&year_selected=<?php echo isset($_GET['year_selected']) ? $_GET['year_selected'] : 2024; ?>&month_selected=<?php echo isset($_GET['month_selected']) ? $_GET['month_selected'] : ''; ?>&day_selected=<?php echo isset($_GET['day_selected']) ? $_GET['day_selected'] : ''; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>

            </div>

            <!-- Date Range Filter -->
            <form method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-control" name="date_range" id="date_range" onchange="updateFilters()">
                            <option value="daily" <?php echo isset($_GET['date_range']) && $_GET['date_range'] == 'daily' ? 'selected' : ''; ?>>Daily</option>
                            <option value="monthly" <?php echo isset($_GET['date_range']) && $_GET['date_range'] == 'monthly' ? 'selected' : ''; ?>>Monthly</option>
                            <option value="yearly" <?php echo isset($_GET['date_range']) && $_GET['date_range'] == 'yearly' ? 'selected' : ''; ?>>Yearly</option>
                        </select>
                    </div>
                    <div class="col-md-3" id="filter_block">
                        <!-- Specific filter inputs will be populated here -->
                        <?php if (isset($_GET['date_range'])): ?>
                            <!-- Dynamic filters based on selection -->
                            <?php if ($_GET['date_range'] == 'daily'): ?>
                                <input type="date" class="form-control" name="day_selected" value="<?php echo isset($_GET['day_selected']) ? $_GET['day_selected'] : ''; ?>">
                            <?php elseif ($_GET['date_range'] == 'monthly'): ?>
                                <select class="form-control" name="month_selected">
                                    <option value="">Select Month</option>
                                    <option value="1" <?php echo isset($_GET['month_selected']) && $_GET['month_selected'] == 1 ? 'selected' : ''; ?>>January</option>
                                    <option value="2" <?php echo isset($_GET['month_selected']) && $_GET['month_selected'] == 2 ? 'selected' : ''; ?>>February</option>
                                    <option value="3" <?php echo isset($_GET['month_selected']) && $_GET['month_selected'] == 3 ? 'selected' : ''; ?>>March</option>
                                    <option value="4" <?php echo isset($_GET['month_selected']) && $_GET['month_selected'] == 4 ? 'selected' : ''; ?>>April</option>
                                    <option value="5" <?php echo isset($_GET['month_selected']) && $_GET['month_selected'] == 5 ? 'selected' : ''; ?>>May</option>
                                    <option value="6" <?php echo isset($_GET['month_selected']) && $_GET['month_selected'] == 6 ? 'selected' : ''; ?>>June</option>
                                    <option value="7" <?php echo isset($_GET['month_selected']) && $_GET['month_selected'] == 7 ? 'selected' : ''; ?>>July</option>
                                    <option value="8" <?php echo isset($_GET['month_selected']) && $_GET['month_selected'] == 8 ? 'selected' : ''; ?>>August</option>
                                    <option value="9" <?php echo isset($_GET['month_selected']) && $_GET['month_selected'] == 9 ? 'selected' : ''; ?>>September</option>
                                    <option value="10" <?php echo isset($_GET['month_selected']) && $_GET['month_selected'] == 10 ? 'selected' : ''; ?>>October</option>
                                    <option value="11" <?php echo isset($_GET['month_selected']) && $_GET['month_selected'] == 11 ? 'selected' : ''; ?>>November</option>
                                    <option value="12" <?php echo isset($_GET['month_selected']) && $_GET['month_selected'] == 12 ? 'selected' : ''; ?>>December</option>
                                </select>
                                <input type="number" class="form-control mt-2" name="year_selected" value="<?php echo isset($_GET['year_selected']) ? $_GET['year_selected'] : ''; ?>" placeholder="Enter Year">
                            <?php elseif ($_GET['date_range'] == 'yearly'): ?>
                                <input type="number" class="form-control" name="year_selected" value="<?php echo isset($_GET['year_selected']) ? $_GET['year_selected'] : ''; ?>" placeholder="Enter Year">
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
                    </div>
                </div>
            </form>

            <!-- Check and display success messages -->
            <?php if (isset($_SESSION['status'])): ?>
                <script>
                    $(document).ready(function() {
                        toastr.success("<?php echo $_SESSION['status']; ?>");
                    });
                </script>
                <?php unset($_SESSION['status']); ?>
            <?php endif; ?>

            <!-- Cards Section -->
            <div class="row">
                <?php
                    // Function to generate a random color
                    function getRandomColor() {
                        $letters = '0123456789ABCDEF';
                        $color = '#';
                        for ($i = 0; $i < 6; $i++) {
                            $color .= $letters[rand(0, 15)];
                        }
                        return $color;
                    }

                    // Get the selected date range filter
                    $date_range = isset($_GET['date_range']) ? $_GET['date_range'] : 'daily';
                    $year_selected = isset($_GET['year_selected']) ? $_GET['year_selected'] : 2024;
                    $month_selected = isset($_GET['month_selected']) ? $_GET['month_selected'] : '';
                    $day_selected = isset($_GET['day_selected']) ? $_GET['day_selected'] : '';

                    // Check if any filter is applied
                    $filters_applied = isset($_GET['date_range']) || isset($_GET['year_selected']) || isset($_GET['month_selected']) || isset($_GET['day_selected']);

                    // If no filters are applied, calculate the total number of tourists per gender
                    if (!$filters_applied) {
                        // SQL query to get the total tourist count per gender (ignoring date range)
                        $query = "SELECT g.Gender, COUNT(*) AS TouristCount
                                  FROM tour t
                                  JOIN tourist tr ON t.TouristID = tr.TouristID
                                  JOIN gender g ON tr.GenderID = g.Gender_ID
                                  GROUP BY g.Gender";
                        $query_run = mysqli_query($connection, $query);
                    } else {
                        // Set the date format based on the filter
                        switch ($date_range) {
                            case 'monthly':
                                $date_format = "%Y-%m"; // Month (Year-Month format)
                                break;
                            case 'yearly':
                                $date_format = "%Y"; // Year (Year format)
                                break;
                            default:
                                $date_format = "%Y-%m-%d"; // Daily (Year-Month-Day format)
                                break;
                        }

                        // SQL query to get the tourist count based on the selected date range
                        $query = "SELECT DATE_FORMAT(t.StartDateTime, '$date_format') AS DateRange, g.Gender, COUNT(*) AS TouristCount
                                  FROM tour t
                                  JOIN tourist tr ON t.TouristID = tr.TouristID
                                  JOIN gender g ON tr.GenderID = g.Gender_ID
                                  WHERE YEAR(t.StartDateTime) = '$year_selected'";

                        // Apply filters based on the selected range
                        if ($date_range == 'daily' && $day_selected) {
                            $query .= " AND DATE(t.StartDateTime) = '$day_selected'";
                        } elseif ($date_range == 'monthly' && $month_selected) {
                            $query .= " AND MONTH(t.StartDateTime) = '$month_selected'";
                        }

                        $query .= " GROUP BY DateRange, g.Gender
                                    ORDER BY DateRange, g.Gender";
                        $query_run = mysqli_query($connection, $query);
                    }

                    // Display the total number of tourists per gender only if no filters are applied
                    if (!$filters_applied) {
                        while ($row = mysqli_fetch_assoc($query_run)) {
                            $gender = $row['Gender'];
                            $count = $row['TouristCount'];

                            // Random color for the card header
                            $random_color = getRandomColor();

                            // Output the card for total tourists per gender
                            echo "<div class='col-md-4 mb-4'>
                                    <div class='card shadow-lg border-0 rounded-lg h-100'>
                                        <div class='card-header' style='background-color: $random_color; color: white;'>
                                            <h5 class='card-title'>$gender</h5>
                                        </div>
                                        <div class='card-body'>
                                            <p class='card-text text-center fs-4'>Total Tourists: $count</p>
                                        </div>
                                    </div>
                                </div>";
                        }
                    } else {
                        // If filters are applied, display the filtered tourist data
                        $previous_date = ''; // To track if we're still on the same date range
                        $gender_count = []; // To store counts per gender for each date range
                        $displayed_genders = []; // To store genders that have already been displayed for the current week/month

                        // Function to calculate date range for monthly view
                        function getMonthDateRange($year, $monthNumber) {
                            $startDate = "$year-$monthNumber-01";
                            $endDate = date("Y-m-t", strtotime($startDate));
                            return date("F j, Y", strtotime($startDate)) . " - " . date("F j, Y", strtotime($endDate));
                        }

                        // Loop through the results to display filtered data
                        while ($row = mysqli_fetch_assoc($query_run)) {
                            $date_range_value = $row['DateRange'];
                            $gender = $row['Gender'];
                            $count = $row['TouristCount'];

                            // Avoid duplicate cards for the same gender and date range
                            if (in_array($gender . "-" . $date_range_value, $displayed_genders)) {
                                continue; // Skip if the gender for this date range is already shown
                            }

                            // Determine the readable date range for monthly view
                            if ($date_range == 'monthly') {
                                $date_range_display = getMonthDateRange(substr($date_range_value, 0, 4), substr($date_range_value, 5));
                            } else {
                                $date_range_display = $date_range_value; // For daily or yearly
                            }

                            // Random color for the card header
                            $random_color = getRandomColor();

                            // Output the card for filtered tourist data
                            echo "<div class='col-md-4 mb-4'>
                                    <div class='card shadow-lg border-0 rounded-lg h-100'>
                                        <div class='card-header' style='background-color: $random_color; color: white;'>
                                            <h5 class='card-title'>$date_range_display - $gender</h5>
                                        </div>
                                        <div class='card-body'>
                                            <p class='card-text text-center fs-4'>Total Tourists: $count</p>
                                        </div>
                                    </div>
                                </div>";

                            // Mark this gender and date range as displayed
                            $displayed_genders[] = $gender . "-" . $date_range_value;
                        }
                    }
                ?>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php
        include('includes/footer.php'); 
        include('includes/scripts.php');   
    ?>

</div>
<!-- End of Page Wrapper -->

<script>
// JavaScript to dynamically show the filter input fields based on date range selection
function updateFilters() {
    var dateRange = document.getElementById('date_range').value;
    var filterBlock = document.getElementById('filter_block');

    if (dateRange == 'daily') {
        filterBlock.innerHTML = '<input type="date" class="form-control" name="day_selected">';
    } else if (dateRange == 'monthly') {
        filterBlock.innerHTML = ` 
            <select class="form-control" name="month_selected">
                <option value="">Select Month</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
            <input type="number" class="form-control mt-2" name="year_selected" placeholder="Enter Year">
        `;
    } else if (dateRange == 'yearly') {
        filterBlock.innerHTML = '<input type="number" class="form-control" name="year_selected" placeholder="Enter Year">';
    }
}
</script>
