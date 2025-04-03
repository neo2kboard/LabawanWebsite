<?php
include('security.php');

if(isset($_POST['registerbtn']))
{
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $touristtype = $_POST['touristtype'];

    $query = "INSERT INTO tourist (FirstName, LastName, Age, GenderID, Nationality, TouristTypeID) 
                VALUES ('$fname', '$lname', '$age', '$gender', '$nationality', '$touristtype')";

    $query_run = mysqli_query($connection, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Tourist Added Successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: tourist_registry.php');
    }
    else 
    {
        $_SESSION['status'] = "Tourist Not Added";
        $_SESSION['status_code'] = "error";
        header('Location: tourist_registry.php');  
    }
}

?>
