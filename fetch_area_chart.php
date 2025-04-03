<?php
include('security.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Query to get tourist arrivals per month for the current year
$query = "SELECT MONTH(StartDateTime) AS month, COUNT(*) AS count 
          FROM tour 
          WHERE YEAR(StartDateTime) = YEAR(CURDATE())
          GROUP BY MONTH(StartDateTime) 
          ORDER BY MONTH(StartDateTime)";

$result = $connection->query($query);

$tourist_arrivals = array_fill(1, 12, 0); // Initialize array with 12 elements (one for each month)

while ($row = $result->fetch_assoc()) {
    $tourist_arrivals[(int)$row['month']] = (int)$row['count'];
}

echo json_encode($tourist_arrivals);
?>
