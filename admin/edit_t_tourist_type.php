<?php
include('../security.php');

if(isset($_POST['updatebtn']))
{
    $id = $_POST['edit_id'];
    $touristtype = $_POST['edit_touristtype'];

    $query = "UPDATE tourist_type SET Class='$touristtype' WHERE TouristTypeID='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status_ud'] = "Tourist Type Updated Successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: tourist_type.php'); 
    }
    else
    {
        $_SESSION['status_ud'] = "Tourist Type is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: tourist_type.php'); 
    }
}

?>