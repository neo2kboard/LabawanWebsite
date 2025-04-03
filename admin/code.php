<?php
include('../security.php');

if(isset($_POST['login_btn']))
{
    $username_login = $_POST['Username'];
    $password_login = $_POST['Password'];

    $query = "SELECT * FROM users WHERE Username='$username_login' AND Password='$password_login' ";
    $query_run = mysqli_query($connection, $query);
    $role = mysqli_fetch_array($query_run);

    if($role['Role'] == "Admin")
    {
        $_SESSION['Username'] = $username_login;
        header('Location: dash.php');
    }
    else if($role['Role'] == "User")
    {
        $_SESSION['Username'] = $username_login;
        header('Location: ../dash.php');
    }
    else
    {
        $_SESSION['status'] = 'Username id / Password is Invalid';
        header('Location: ../index.php');
    }
}


?>