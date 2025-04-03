<?php
    include('security.php');
    include('includes/header_mt.php');
    include('includes/navbar_ot.php');
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
                <h1 class="h3 mb-4 text-gray-800">Tour > Ongoing Tours</h1>
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
                               tour.StartTime AS StartTime
                        FROM tour 
                        INNER JOIN tourist ON tour.TouristID = tourist.TouristID
                        INNER JOIN tour_guide ON tour.TourGuideID = tour_guide.TourGuideID
                        WHERE tour.Status = 0
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
                                    <th>Time Started</th>
                                    <th>Edit</th>
                                    <th>End Tour</th>
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
                                            <td><?php echo $row['StartTime']; ?></td>
                                            <td>
                                                <form action="edit_tour.php" method="post">
                                                    <input type="hidden" name="edit_id" value="<?php echo $tour_num; ?>">
                                                    <button type="submit" name="edit_btn" class="btn btn-success">EDIT</button>
                                                </form>
                                            </td>
                                            <td>
                                                <!-- End Tour Button -->
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#endTourModal" data-tourid="<?php echo $tour_num; ?>">End Tour</button>
                                            </td>
                                                    
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='9' class='text-center'>No Ongoing Tours</td></tr>";
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


<!-- Confirmation Modal -->
<div class="modal fade" id="endTourModal" tabindex="-1" role="dialog" aria-labelledby="endTourModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="end_tour.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="endTourModalLabel">End Tour</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to end this tour?
                    <input type="hidden" name="tour_num" id="delete_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="end_tour_btn" class="btn btn-danger">End Tour</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#endTourModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var tourId = button.data('tourid'); // Extract info from data-* attributes
        
        // Update the modal's content. We'll use jQuery here.
        var modal = $(this);
        modal.find('.modal-body #delete_id').val(tourId);
    });


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
