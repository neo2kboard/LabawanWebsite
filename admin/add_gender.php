<?php
include('../security.php');

if(isset($_POST['registerbtn']))
{
    $id = $_POST['id'];
    $gender = $_POST['gender'];

    $query = "INSERT INTO gender (Gender_ID, Gender) VALUES ('$id', '$gender')";
    $query_run = mysqli_query($connection, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Gender Added Successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: gender.php');
    }
    else 
    {
        $_SESSION['status'] = "Gender Not Added";
        $_SESSION['status_code'] = "error";
        header('Location: gender.php');  
    }
}

?>
