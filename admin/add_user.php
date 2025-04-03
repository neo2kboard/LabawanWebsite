<?php
include('../security.php');

if(isset($_POST['registerbtn']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $query = "INSERT INTO users (Username, Password, Role) VALUES ('$username', '$password', '$role')";
    $query_run = mysqli_query($connection, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "User Added Successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: manage_users.php');
    }
    else 
    {
        $_SESSION['status'] = "User Not Added";
        $_SESSION['status_code'] = "error";
        header('Location: manage_users.php');  
    }
}

?>