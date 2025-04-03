<?php
session_start();
include('db/dbconfig.php');

if($connection)
{
    // echo "Database Connected";
}
else {
    header("Location: database/dbconfig.php");
}

if(!$_SESSION['Username'])
{
    header('Location: index.php');
}

?>