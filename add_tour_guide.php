<?php
include('security.php');

if(isset($_POST['registerbtn']))
{
    $name = $_POST['name'];
    $age = $_POST['age'];

    $query = "INSERT INTO tour_guide (Name, Age) VALUES ('$name', '$age')";
    $query_run = mysqli_query($connection, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Tour Guide Added Successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: manage_tour_guide.php');
    }
    else 
    {
        $_SESSION['status'] = "Tour Guide Not Added";
        $_SESSION['status_code'] = "error";
        header('Location: manage_tour_guide.php');  
    }
}

?>
