<?php
include('../security.php');

if(isset($_POST['delete_btn']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM tourist_type WHERE TouristTypeID='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status_del'] = "Tourist Type is Deleted!";
        $_SESSION['status_code'] = "success";
        header('Location: tourist_type.php'); 
    }
    else
    {
        $_SESSION['status_del'] = "Tourist Type is NOT DELETED";       
        $_SESSION['status_code'] = "error";
        header('Location: tourist_type.php'); 
    }    
}
?>