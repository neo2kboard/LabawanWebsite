<?php
    include('security.php');
    include('includes/header_mt.php');
    include('includes/navbar_et.php');
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
                <h1 class="h3 mb-4 text-gray-800">Tour > Ended Tours</h1>
            </div>

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
                    <h6 class="m-0 font-weight-bold text-primary">Edit Tourist</h6>
                </div>
                <div class="card-body">
                        <style>
                            .form-group, .form-control, .select2-results__option, .dataTable {
                                color: black !important; 
                            }
                            
                        </style>
                    <?php
                    // Query to fetch ongoing tours with relevant details
                    $query = "SELECT * FROM tour";
                    $query = "
                        SELECT tour.Tour_Number, 
                               CONCAT(tourist.FirstName, ' ', tourist.LastName) AS FullName, 
                               tour_guide.Name AS TourGuide,
                               tour.StartDateTime AS StartDateTime,
                               tour.EndDateTime AS EndDateTime,
                               tour.StartTime AS StartTime,
                               tour.EndTime AS EndTime,
                               tour.Duration AS Duration
                        FROM tour 
                        INNER JOIN tourist ON tour.TouristID = tourist.TouristID
                        INNER JOIN tour_guide ON tour.TourGuideID = tour_guide.TourGuideID
                        WHERE tour.Status = 1
                        GROUP BY tour.Tour_Number, tour_guide.Name
                        ORDER BY tour.Tour_Number
                    ";
                    $query_run = mysqli_query($connection, $query);
                    ?>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>View</th>
                                    <th>Tour Number</th>
                                    <th>Tour Guide Name</th>
                                    <th>Date Started</th>
                                    <th>Date Ended</th>
                                    <th>Time Started</th>
                                    <th>Time Ended</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($query_run) > 0) {
                                    while ($row = mysqli_fetch_assoc($query_run)) {
                                        $tour_num = $row['Tour_Number'];
                                ?>
                                        <tr>
                                            <td>
                                                <!-- View Tourists Button -->
                                                <button class="btn btn-info" data-toggle="modal" data-target="#viewTouristsModal" data-tour-num="<?php echo $tour_num; ?>">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </td>
                                            <td><?php echo $tour_num; ?></td>
                                            <td><?php echo $row['TourGuide']; ?></td>
                                            <td><?php echo $row['StartDateTime']; ?></td>
                                            <td><?php echo $row['EndDateTime']; ?></td>
                                            <td><?php echo $row['StartTime']; ?></td>
                                            <td><?php echo $row['EndTime']; ?></td>
                                            <td><?php echo $row['Duration']; ?></td>
                                            <td>
                                                <button type="submit" name="end_tour_btn" class="btn btn-success">Completed</button>
                                            </td>
                                                    
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='9' class='text-center'>No Ended Tours</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
    <!-- End of Main Content -->

<?php
    include('includes/footer.php'); 
    include('includes/scripts_mt.php');   
?> 

<!-- Modal for Viewing Tourists -->
<div class="modal fade" id="viewTouristsModal" tabindex="-1" role="dialog" aria-labelledby="viewTouristsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <style>
            .modal-content{
                color: black !important; 
                }
        </style>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTouristsModalLabel">Tour Guide & Tourists</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="touristsContent">
                    <!-- Content will be dynamically loaded here -->
                    <div class="text-center">Loading...</div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#viewTouristsModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var tourNum = button.data('tour-num'); // Using tour number

        if (!tourNum && tourNum !== 0) {
            $('#touristsContent').html('<div class="text-danger">Invalid request: Missing tour number.</div>');
            return;
        }

        $.ajax({
            url: 'get_tourists.php',
            method: 'GET',
            data: { tour_num: tourNum }, // Sending tour number
            success: function(response) {
                $('#touristsContent').html(response);
            },
            error: function() {
                $('#touristsContent').html('<div class="text-danger">Failed to load data. Please try again.</div>');
            }
        });
    });
});

</script>
