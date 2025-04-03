<?php
include('security.php');

if(isset($_POST['updatebtn']))
{
    $id = $_POST['edit_id'];
    $name = $_POST['edit_name'];
    $age = $_POST['edit_age'];

    $query = "UPDATE tour_guide SET Name='$name', Age='$age' WHERE TourGuideID='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status_ud'] = "Tour Guide Updated Successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: manage_tour_guide.php'); 
    }
    else
    {
        $_SESSION['status_ud'] = "Tour Guide is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: manage_tour_guide.php'); 
    }
}

?>