<?php
include('security.php');

// Get the current date
$currentDate = date('Y-m-d');

$query = "SELECT COUNT(*) AS count FROM tour WHERE DATE(StartDateTime) = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param('s', $currentDate);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();
echo json_encode(['count' => $row['count']]);
?>
