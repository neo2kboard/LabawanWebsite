<?php
include('security.php');

// Set the timezone to Philippine Time
date_default_timezone_set('Asia/Manila');

if (isset($_POST['add_tour_btn'])) {
    $tourist_ids = isset($_POST['tourist_ids']) ? $_POST['tourist_ids'] : [];
    $tourguide_id = $_POST['tourguide_id'];
    $start_date = date('Y-m-d');  // Automatically sets today's date (YYYY-MM-DD)
    $start_time = date('H:i:s');  // Automatically sets current time (HH:MM:SS)
    $end_time = $_POST['end_time'];
    $blood_pressures = isset($_POST['blood_pressure']) ? $_POST['blood_pressure'] : [];
    $status = 0;  // Default status is set to 0 (Active) when starting the tour

    if (empty($tourist_ids)) {
        $_SESSION['status'] = "Please add at least one tourist.";
        $_SESSION['status_code'] = "error";
        header('Location: start_tour.php');
        exit();
    }

    // Check if the selected tour guide already has an active tour
    $check_tour_query = "SELECT * FROM tour WHERE TourGuideID = '$tourguide_id' AND Status = 0 AND EndDateTime >= CURDATE()";
    $check_tour_result = mysqli_query($connection, $check_tour_query);

    if (mysqli_num_rows($check_tour_result) > 0) {
        $_SESSION['status'] = "The selected tour guide already has an active tour.";
        $_SESSION['status_code'] = "error";
        header('Location: start_tour.php');
        exit();
    }

    // Step 1: Get the next available Tour Number
    $tour_number_query = "SELECT MAX(Tour_Number) AS max_tour_number FROM tour";
    $tour_number_result = mysqli_query($connection, $tour_number_query);
    $tour_number_row = mysqli_fetch_assoc($tour_number_result);
    $new_tour_number = $tour_number_row['max_tour_number'] + 1;  // Increment the max tour number by 1

    // Step 2: Insert Tour for each Tourist and Assign the same Tour Number
    $success_count = 0;

    foreach ($tourist_ids as $index => $tourist_id) {
        $blood_pressure = $blood_pressures[$index];

        // Insert the tour with the same Tour Number but unique TourID for each tourist
        $query = "INSERT INTO tour (TouristID, TourGuideID, StartDateTime, StartTime, EndDateTime, Blood_Pressure, Status, Tour_Number) 
                  VALUES ('$tourist_id', '$tourguide_id', '$start_date', '$start_time', '$end_time', '$blood_pressure', '$status', '$new_tour_number')";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            $success_count++;
        } else {
            error_log("Error inserting tourist ID $tourist_id: " . mysqli_error($connection));
            break;
        }
    }

    // After inserting the tours, update session and redirect
    if ($success_count == count($tourist_ids)) {
        $_SESSION['status'] = "Tour Added Successfully!";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Tour Not Added. Successfully added $success_count tourist(s). Error: " . mysqli_error($connection);
        $_SESSION['status_code'] = "error";
    }

    header('Location: start_tour.php');
}
?>
