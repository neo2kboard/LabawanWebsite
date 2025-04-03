<?php
include('../security.php');

if(isset($_POST['delete_btn']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM users WHERE UserID='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status_del'] = "User is Deleted!";
        $_SESSION['status_code'] = "success";
        header('Location: manage_users.php'); 
    }
    else
    {
        $_SESSION['status_del'] = "User is NOT DELETED";       
        $_SESSION['status_code'] = "error";
        header('Location: manage_users.php'); 
    }    
}
?>
?>