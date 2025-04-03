<?php
include('../security.php');

if(isset($_POST['delete_btn']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM gender WHERE Gender_ID ='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status_del'] = "Gender is Deleted!";
        $_SESSION['status_code'] = "success";
        header('Location: gender.php'); 
    }
    else
    {
        $_SESSION['status_del'] = "Gender is NOT DELETED";       
        $_SESSION['status_code'] = "error";
        header('Location: gender.php'); 
    }    
}
?>