<?php
include('security.php');

// Get the month from the request, if available
$month = isset($_GET['month']) ? $_GET['month'] : '';

// Build the query dynamically based on the month
$query = "SELECT
                 tourist_type.Class AS tourist_type, 
                 tour.StartDateTime AS start_date, 
                 tour.EndDateTime AS end_date 
          FROM tour 
          INNER JOIN tourist ON tour.TouristID = tourist.TouristID 
          INNER JOIN tourist_type ON tourist.TouristTypeID = tourist_type.TouristTypeID";

if (!empty($month)) {
    // Add condition for filtering by month
    $query .= " WHERE MONTH(tour.StartDateTime) = ? AND YEAR(tour.StartDateTime) = YEAR(CURDATE())";
}

$stmt = $connection->prepare($query);

if (!empty($month)) {
    // Bind the month parameter
    $stmt->bind_param('s', $month);
}

$stmt->execute();
$result = $stmt->get_result();

$tourists = array();
while ($row = $result->fetch_assoc()) {
    $tourists[] = $row;
}

echo json_encode($tourists);
?>
