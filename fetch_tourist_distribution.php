<?php
include('security.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$query = "SELECT tourist_type.Class AS tourist_type, COUNT(*) AS count 
          FROM tourist 
          INNER JOIN tourist_type ON tourist.TouristTypeID = tourist_type.TouristTypeID 
          GROUP BY tourist_type.Class";

$result = $connection->query($query);

$tourist_distribution = array();
$total_count = 0;

while ($row = $result->fetch_assoc()) {
    $tourist_distribution[] = $row;
    $total_count += $row['count'];
}

// Calculate percentages
foreach ($tourist_distribution as &$dist) {
    $dist['percentage'] = ($dist['count'] / $total_count) * 100;
}

echo json_encode($tourist_distribution);
?>
