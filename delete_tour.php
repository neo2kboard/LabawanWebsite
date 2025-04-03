<?php
include('security.php');

if (isset($_POST['delete_btn'])) {
    $tour_num = $_POST['delete_id'];

    // Prepare the delete query to remove all tours with the same Tour_Number
    $query = "DELETE FROM tour WHERE Tour_Number = ?";

    if ($stmt = $connection->prepare($query)) {
        $stmt->bind_param("i", $tour_num);
        $stmt->execute();
        $stmt->close();

        // Redirect back to the ongoing tours page with a success message
        $_SESSION['status'] = "Tours with number $tour_num have been deleted successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: ongoing_tours.php');
    } else {
        $_SESSION['status'] = "Failed to delete tours.";
        $_SESSION['status_code'] = "error";
        header('Location: ongoing_tours.php');
    }
}
?>
