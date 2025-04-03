<?php
include('security.php');

// Get the selected date range filter (if any)
$date_range = isset($_GET['date_range']) ? $_GET['date_range'] : 'daily';
$year_selected = isset($_GET['year_selected']) ? $_GET['year_selected'] : 2024;
$month_selected = isset($_GET['month_selected']) ? $_GET['month_selected'] : '';
$day_selected = isset($_GET['day_selected']) ? $_GET['day_selected'] : '';

// Check if any filter is applied
$filters_applied = isset($_GET['date_range']) || isset($_GET['year_selected']) || isset($_GET['month_selected']) || isset($_GET['day_selected']);

// Set the query based on whether filters are applied or not
if (!$filters_applied) {
    // If no filters are applied, show the total tourists per gender (no date consideration)
    $query = "SELECT g.Gender, COUNT(*) AS TouristCount
              FROM tour t
              JOIN tourist tr ON t.TouristID = tr.TouristID
              JOIN gender g ON tr.GenderID = g.Gender_ID
              GROUP BY g.Gender";
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
              JOIN gender g ON tr.GenderID = g.Gender_ID";

    // Apply filters based on the selected range
    if ($date_range == 'daily' && $day_selected) {
        $query .= " WHERE DATE(t.StartDateTime) = '$day_selected'";
    } elseif ($date_range == 'monthly' && $month_selected) {
        $query .= " WHERE MONTH(t.StartDateTime) = '$month_selected'";
    } elseif ($date_range == 'yearly' && $year_selected) {
        $query .= " WHERE YEAR(t.StartDateTime) = '$year_selected'";
    }

    $query .= " GROUP BY DateRange, g.Gender
                ORDER BY DateRange, g.Gender";
}

// Execute the query
$result = mysqli_query($connection, $query);

// Set the headers to force download as CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="tourist_arrival_report.csv"');

// Open the output stream for the CSV
$output = fopen('php://output', 'w');

// Write the column headers based on whether filters are applied
if (!$filters_applied) {
    fputcsv($output, array('Gender', 'Total Tourist Count'));
} else {
    // For filtered data, include DateRange along with Gender and Count
    fputcsv($output, array('Date Range', 'Gender', 'Tourist Count'));
}

// Write the rows of data to the CSV
while ($row = mysqli_fetch_assoc($result)) {
    if (!$filters_applied) {
        // If no filters are applied, only show Gender and Tourist Count
        fputcsv($output, array($row['Gender'], $row['TouristCount']));
    } else {
        // If filters are applied, include DateRange, Gender, and Tourist Count
        fputcsv($output, array($row['DateRange'], $row['Gender'], $row['TouristCount']));
    }
}

// Close the output stream
fclose($output);

exit();
?>
