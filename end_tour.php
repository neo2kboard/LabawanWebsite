<?php
include('security.php');

// Set the timezone to Philippine Time
date_default_timezone_set('Asia/Manila');

if (isset($_POST['end_tour_btn'])) {
    $tour_num = $_POST['tour_num'];
    $currentDateTime = date("Y-m-d H:i:s"); // Use 24-hour format
    $currentTime = date("H:i:s");          // Use 24-hour format for time

    // Fetch the start datetime and time from the database
    $query = "SELECT CONCAT(StartDateTime, ' ', StartTime) AS StartDateTime FROM tour WHERE Tour_Number = ? LIMIT 1";
    if ($stmt = $connection->prepare($query)) {
        $stmt->bind_param("i", $tour_num);
        $stmt->execute();
        $stmt->bind_result($startDateTime);
        $stmt->fetch();
        $stmt->close();

        if (empty($startDateTime)) {
            $_SESSION['status'] = "Start date and time not found for the tour.";
            $_SESSION['status_code'] = "error";
            header('Location: ongoing_tours.php');
            exit();
        }
    } else {
        $_SESSION['status'] = "Failed to fetch start time.";
        $_SESSION['status_code'] = "error";
        header('Location: ongoing_tours.php');
        exit();
    }

    // Calculate the duration in seconds
    $startTimeStamp = strtotime($startDateTime);
    $endTimeStamp = strtotime($currentDateTime);

    if ($startTimeStamp === false || $endTimeStamp === false) {
        $_SESSION['status'] = "Failed to parse date-time.";
        $_SESSION['status_code'] = "error";
        header('Location: ongoing_tours.php');
        exit();
    }

    $durationInSeconds = $endTimeStamp - $startTimeStamp;

    // Prevent negative duration
    if ($durationInSeconds < 0) {
        $durationInSeconds = 0;
    }

    // Format the duration as "HH:MM:SS"
    $hours = floor($durationInSeconds / 3600);
    $minutes = floor(($durationInSeconds % 3600) / 60);
    $seconds = $durationInSeconds % 60;
    $durationFormatted = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

    // Update the tour's end datetime, end time, duration, and status (set Status to 1)
    $query = "UPDATE tour SET Status = 1, EndDateTime = ?, EndTime = ?, Duration = ? WHERE Tour_Number = ?";
    if ($stmt = $connection->prepare($query)) {
        $stmt->bind_param("sssi", $currentDateTime, $currentTime, $durationFormatted, $tour_num);
        $stmt->execute();
        $stmt->close();

        $_SESSION['status'] = "Tour ended successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: ongoing_tours.php');
    } else {
        $_SESSION['status'] = "Failed to end tour.";
        $_SESSION['status_code'] = "error";
        header('Location: ongoing_tours.php');
    }
}
?>
