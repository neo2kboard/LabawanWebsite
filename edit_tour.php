<?php
include('security.php');
include('includes/header_mt.php');
include('includes/navbar_ot.php');

if (isset($_POST['edit_btn'])) {
    $tour_number = $_POST['edit_id'];

    // Fetch tour details by Tour Number
    $query = "SELECT tour.TourID, tour.Tour_Number, tourist.TouristID, tour.TourGuideID, tourist.FirstName, tourist.LastName, tour.Blood_Pressure, tour_guide.Name AS TourGuide
              FROM tour
              INNER JOIN tourist ON tour.TouristID = tourist.TouristID
              INNER JOIN tour_guide ON tour.TourGuideID = tour_guide.TourGuideID
              WHERE tour.Tour_Number = '$tour_number'";
    $query_run = mysqli_query($connection, $query);
    $tourists = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

    // Fetch available tour guides without active tours
    $available_guides_query = "SELECT * FROM tour_guide WHERE TourGuideID NOT IN (SELECT TourGuideID FROM tour WHERE Status = 'Active')";
    $available_guides_run = mysqli_query($connection, $available_guides_query);
    $available_guides = mysqli_fetch_all($available_guides_run, MYSQLI_ASSOC);

    // Fetch tourists without active tours
    $available_tourists_query = "SELECT * FROM tourist WHERE TouristID NOT IN (SELECT TouristID FROM tour WHERE Status = 'Active')";
    $available_tourists_run = mysqli_query($connection, $available_tourists_query);
    $available_tourists = mysqli_fetch_all($available_tourists_run, MYSQLI_ASSOC);
}
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <?php include('includes/topbar.php') ?>
        <!-- End of Topbar -->

        <link href="path/to/select2.min.css" rel="stylesheet" />
        <script src="path/to/select2.min.js"></script>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Edit Tour</h1>
            </div>

            <?php if (isset($_SESSION['status'])): ?>
                <script>
                    $(document).ready(function() {
                        var statusMessage = "<?php echo $_SESSION['status']; ?>";
                        var statusCode = "<?php echo $_SESSION['status_code']; ?>";

                        if (statusCode === 'error') {
                            toastr.error(statusMessage);
                        } else {
                            toastr.success(statusMessage);
                        }
                    });
                </script>
                <?php unset($_SESSION['status']); ?>
            <?php endif; ?>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Tourist</h6>
                </div>
                <div class="card-body">
                    <style>
                        .form-group, .form-control, table {
                            color: black !important; 
                        }
                    </style>

                    <form id="mainForm" action="update_tour.php" method="POST">
                        <input type="hidden" name="tour_number" value="<?php echo $tour_number; ?>">

                        <!-- Display and Edit Tour Guide -->
                        <div class="form-group">
                            <label>New Tour Guide:</label>
                            <select name="tour_guide_id" class="form-control select2" required>
                                <option value="" disabled selected>Select Tour Guide</option>
                                <?php
                                    // Query to fetch tour guides who don't have active tours (Status = 0)
                                    $tourguide_query = "SELECT * FROM tour_guide WHERE TourGuideID NOT IN (
                                                        SELECT TourGuideID FROM tour WHERE Status = 0
                                                    )";
                                    $tourguide_query_run = mysqli_query($connection, $tourguide_query);

                                    if(mysqli_num_rows($tourguide_query_run) > 0) {
                                        // Include the current tour guide in the dropdown as an option
                                        echo "<option value='" . $tourists[0]['TourGuideID'] . "' selected>" . $tourists[0]['TourGuide'] . "</option>";

                                        // Fetch and display other available tour guides
                                        while($row = mysqli_fetch_assoc($tourguide_query_run)) {
                                            // Skip the current tour guide if it's already added
                                            if ($row['TourGuideID'] != $tourists[0]['TourGuideID']) {
                                                echo "<option value='" . $row['TourGuideID'] . "'>" . $row['Name'] . "</option>";
                                            }
                                        }
                                    } else {
                                        echo "<option value=''>No Available Tour Guides</option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <h4 class="mt-4 mb-3">Tourists</h4>
                        <div id="addedTouristsContainer" class="mb-3">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tourist Name</th>
                                            <th>Blood Pressure</th>
                                        </tr>
                                    </thead>
                                    <tbody id="touristTableBody">
                                        <?php foreach ($tourists as $tourist): ?>
                                            <tr>
                                                <td><?php echo $tourist['FirstName'] . ' ' . $tourist['LastName']; ?></td>
                                                <td>
                                                    <input type="text" name="blood_pressure[<?php echo $tourist['TourID']; ?>]" value="<?php echo $tourist['Blood_Pressure']; ?>" class="form-control">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <a href="ongoing_tours.php" class="btn btn-danger"> Cancel </a> &ensp;
                        <button type="submit" name="update_tour_btn" class="btn btn-primary">Update Tour</button>
                    </form>

<?php
 include('includes/footer.php'); 
 include('includes/scripts.php');   
?>
