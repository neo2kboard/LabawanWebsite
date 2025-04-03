<?php
include('../security.php');

if(isset($_POST['registerbtn']))
{
    $id = $_POST['id'];
    $touristtype = $_POST['touristtype'];

    $query = "INSERT INTO tourist_type (TouristTypeID, Class) VALUES ('$id', '$touristtype')";
    $query_run = mysqli_query($connection, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Tourist Type Added Successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: tourist_type.php');
    }
    else 
    {
        $_SESSION['status'] = "Tourist Type Not Added";
        $_SESSION['status_code'] = "error";
        header('Location: tourist_type.php');  
    }
}

?>
