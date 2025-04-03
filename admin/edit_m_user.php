<?php
include('../security.php');

if(isset($_POST['updatebtn']))
{
    $id = $_POST['edit_id'];
    $username = $_POST['edit_username'];
    $password = $_POST['edit_password'];
    $role = $_POST['edit_role'];

    $query = "UPDATE users SET Username='$username', Password='$password', Role='$role' WHERE UserID='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status_ud'] = "User Updated Successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: manage_users.php'); 
    }
    else
    {
        $_SESSION['status_ud'] = "User is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: manage_users.php'); 
    }
}

?>