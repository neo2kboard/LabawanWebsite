<?php
include('security.php');

if(isset($_POST['delete_btn']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM tour_guide WHERE TourGuideID='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status_del'] = "Tour Guide is Deleted!";
        $_SESSION['status_code'] = "success";
        header('Location: manage_tour_guide.php'); 
    }
    else
    {
        $_SESSION['status_del'] = "Tour Guide is NOT DELETED";       
        $_SESSION['status_code'] = "error";
        header('Location: manage_tour_guide.php'); 
    }    
}
?>