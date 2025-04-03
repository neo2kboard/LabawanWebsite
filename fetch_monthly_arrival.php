<?php
include('security.php');

// Get the current month
$currentMonth = date('m');
$currentYear = date('Y');

$query = "SELECT COUNT(*) AS count FROM tour WHERE MONTH(StartDateTime) = ? AND YEAR(StartDateTime) = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param('ss', $currentMonth, $currentYear);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();
echo json_encode(['count' => $row['count']]);
?>
