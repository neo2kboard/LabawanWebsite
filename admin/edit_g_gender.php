<?php
include('../security.php');

if(isset($_POST['updatebtn']))
{
    $id = $_POST['edit_id'];
    $gender = $_POST['edit_gender'];

    $query = "UPDATE gender SET Gender='$gender' WHERE Gender_ID='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status_ud'] = "Gender Updated Successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: gender.php'); 
    }
    else
    {
        $_SESSION['status_ud'] = "Gender is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: gender.php'); 
    }
}

?>