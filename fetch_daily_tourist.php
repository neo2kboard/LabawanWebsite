<?php
include('security.php');

// Get the date from the request, if available
$date = isset($_GET['date']) ? $_GET['date'] : '';

$query = "SELECT 
                 tourist_type.Class AS tourist_type, 
                 tour.StartDateTime AS start_date, 
                 tour.EndDateTime AS end_date 
          FROM tour 
          INNER JOIN tourist ON tour.TouristID = tourist.TouristID 
          INNER JOIN tourist_type ON tourist.TouristTypeID = tourist_type.TouristTypeID";

if (!empty($date)) {
    $query .= " WHERE DATE(tour.StartDateTime) = ?";
}

$stmt = $connection->prepare($query);

if (!empty($date)) {
    $stmt->bind_param('s', $date);
}

$stmt->execute();
$result = $stmt->get_result();

$tourists = array();
while ($row = $result->fetch_assoc()) {
    $tourists[] = $row;
}

echo json_encode($tourists);
?>
