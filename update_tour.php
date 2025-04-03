<?php
include('security.php');

// Set the timezone to Philippine Time
date_default_timezone_set('Asia/Manila');

if (isset($_POST['update_tour_btn'])) {
    $tour_number = $_POST['tour_number'];
    $tour_guide_id = $_POST['tour_guide_id'];
    $blood_pressures = $_POST['blood_pressure'];

    // Update tour guide for the specified tour number
    $update_guide_query = "UPDATE tour SET TourGuideID = '$tour_guide_id' WHERE Tour_Number = '$tour_number'";
    mysqli_query($connection, $update_guide_query);

    // Update blood pressure for each tourist
    foreach ($blood_pressures as $tour_id => $bp) {
        $update_bp_query = "UPDATE tour SET Blood_Pressure = '$bp' WHERE TourID = '$tour_id'";
        mysqli_query($connection, $update_bp_query);
    }

    // Redirect back to the ongoing tours page with success message
    $_SESSION['status'] = "Tour updated successfully!";
    header('Location: ongoing_tours.php');
    exit();
}
?>
