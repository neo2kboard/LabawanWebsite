<?php
include('security.php');

// Get the year from the request, if available
$year = isset($_GET['year']) ? $_GET['year'] : '';

$query = "SELECT 
                 tourist_type.Class AS tourist_type, 
                 tour.StartDateTime AS start_date, 
                 tour.EndDateTime AS end_date 
          FROM tour 
          INNER JOIN tourist ON tour.TouristID = tourist.TouristID 
          INNER JOIN tourist_type ON tourist.TouristTypeID = tourist_type.TouristTypeID";

if (!empty($year)) {
    $query .= " WHERE YEAR(tour.StartDateTime) = ?";
}

$stmt = $connection->prepare($query);

if (!empty($year)) {
    $stmt->bind_param('s', $year);
}

$stmt->execute();
$result = $stmt->get_result();

$tourists = array();
while ($row = $result->fetch_assoc()) {
    $tourists[] = $row;
}

echo json_encode($tourists);
?>
