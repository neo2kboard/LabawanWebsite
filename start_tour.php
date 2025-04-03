<?php
    include('security.php');
    include('includes/header_mt.php'); 
    include('includes/navbar_st.php'); 
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <?php include('includes/topbar.php') ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-4 text-gray-800">Tour > Start Tour</h1>
            </div>

            <?php if (isset($_SESSION['status'])): ?>
                <script>
                    $(document).ready(function() {
                        var statusMessage = "<?php echo $_SESSION['status']; ?>";  // Get the session message
                        var statusCode = "<?php echo $_SESSION['status_code']; ?>"; // Get the status code

                        // Display message based on status code
                        if (statusCode === 'error') {
                            toastr.error(statusMessage); // Show in red (error)
                        } else {
                            toastr.success(statusMessage); // Show in green (success)
                        }
                    });
                </script>
                <?php unset($_SESSION['status']); ?>  <!-- Clear the session message to prevent it from showing again -->
            <?php endif; ?>    

            <!-- Check and display success messages -->
            <?php if (isset($_SESSION['status'])): ?>
                <script>
                    $(document).ready(function() {
                        toastr.success("<?php echo $_SESSION['status']; ?>");
                    });
                </script>
                <?php unset($_SESSION['status']); ?>
            <?php endif; ?>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add Tour</h6>
                </div>
                <div class="card-body">
                    <style>
                        .form-group, .form-control {
                            color: black !important; 
                        }
                    </style>

                    <!-- Form to Add Tour -->
                    <form id="mainForm" action="add_tour.php" method="POST" class="container">
                        <div class="form-group">
                            <label>Tour Guide Name</label>
                            <select name="tourguide_id" class="form-control select2" required>
                                <option value="" disabled selected>Select Tour Guide</option>
                                <?php
                                    // Query to fetch tour guides who don't have active tours (Status = 0)
                                    $tourguide_query = "SELECT * FROM tour_guide WHERE TourGuideID NOT IN (
                                                        SELECT TourGuideID FROM tour WHERE Status = 0
                                                    )";
                                    $tourguide_query_run = mysqli_query($connection, $tourguide_query);

                                    if(mysqli_num_rows($tourguide_query_run) > 0) {
                                        while($row = mysqli_fetch_assoc($tourguide_query_run)) {
                                            echo "<option value='" . $row['TourGuideID'] . "'>" . $row['Name'] . "</option>";
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
                                <style>
                                    .table {
                                        color: black !important;
                                    }
                                </style>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tourist Name</th>
                                            <th>Blood Pressure</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="touristTableBody">
                                        <!-- Table rows will be dynamically added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Buttons for Adding and Starting Tour -->
                        <div class="text mt-3">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTouristModal">
                                Add Tourist 
                            </button>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confirmationModal">Start Tour</button>
                        </div>
                    </form>

                        <!-- Confirmation Modal -->
                        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmationModalLabel">Start Tour Confirmation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to start the tour?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" form="mainForm" name="add_tour_btn" class="btn btn-primary">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                   
                    <!-- Modal for Adding Tourist -->
                    <div class="modal fade" id="addTouristModal" tabindex="-1" role="dialog" aria-labelledby="addTouristModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <style>
                                .modal-content, .form-control {
                                    color: black !important;
                                }
                            </style>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addTouristModalLabel">Add Tourist</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Tourist</label>
                                        <select id="touristSelect" class="form-control select2" style="width: 100%;" required>
                                            <option value="" disabled selected>Select Tourist</option>
                                            <?php
                                                // Query to fetch tourists who are not in an active tour (status = 0)
                                                $tourist_query = "
                                                    SELECT * FROM tourist 
                                                    WHERE TouristID NOT IN (
                                                        SELECT TouristID FROM tour WHERE Status = 0
                                                    )
                                                ";
                                                $tourist_query_run = mysqli_query($connection, $tourist_query);

                                                if (mysqli_num_rows($tourist_query_run) > 0) {
                                                    while ($row = mysqli_fetch_assoc($tourist_query_run)) {
                                                        echo "<option value='" . $row['TouristID'] . "'>" . $row['FirstName'] . " " . $row['LastName'] . "</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>No Tourists Found</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Blood Pressure</label>
                                        <input type="text" id="touristBP" class="form-control" placeholder="Blood Pressure (e.g., 120/80)">
                                        <p id="limitMessage" style="display: none; color: red; margin-top: 10px;">
                                            You cannot add more than 5 tourists.
                                        </p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-success" id="addTouristButton" data-dismiss="modal">Save Tourist</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php
        include('includes/footer.php'); 
        include('includes/scripts.php');   
    ?> 

</div>
<!-- End of Page Wrapper -->

<script src="script.js"></script>
