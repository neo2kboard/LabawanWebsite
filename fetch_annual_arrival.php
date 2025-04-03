<?php
include('security.php');

// Get the current year
$currentYear = date('Y');

$query = "SELECT COUNT(*) AS count FROM tour WHERE YEAR(StartDateTime) = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param('s', $currentYear);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();
echo json_encode(['count' => $row['count']]);
?>
