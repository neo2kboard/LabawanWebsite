<?php
include('security.php');

if(isset($_POST['updatebtn'])) {
    // Get data from the form
    $id = $_POST['edit_id'];
    $fname = $_POST['edit_fname'];
    $lname = $_POST['edit_lname'];
    $age = $_POST['edit_age'];
    $gender = $_POST['edit_gender'];  // This should contain the Gender_ID (from the select box)
    $nationality = $_POST['edit_nationality'];
    $touristtype = $_POST['edit_touristtype'];
    
    // Prepare the UPDATE query
    $query = "UPDATE tourist 
              SET FirstName='$fname', LastName='$lname', Age='$age', GenderID='$gender', 
                  Nationality='$nationality', TouristTypeID='$touristtype' 
              WHERE TouristID='$id'";

    // Execute the query
    $query_run = mysqli_query($connection, $query);

    if($query_run) {
        // Success message
        $_SESSION['status_ud'] = "Tourist Updated Successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: tourist_registry.php');
    } else {
        // Error message
        $_SESSION['status_ud'] = "Tourist is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: tourist_registry.php');
    }
}
?>
