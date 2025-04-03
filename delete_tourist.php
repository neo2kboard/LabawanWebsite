<?php
include('security.php');

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];  // Get the TouristID from the URL query parameter

    $query = "DELETE FROM tourist WHERE TouristID='$id'";  // Delete query based on TouristID
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['status_del'] = "Tourist is Deleted!";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status_del'] = "Tourist is NOT DELETED";
        $_SESSION['status_code'] = "error";
    }

    header('Location: tourist_registry.php');  // Redirect to tourist registry page after deletion
}
?>
