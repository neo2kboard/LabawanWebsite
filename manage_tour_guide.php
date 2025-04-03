<?php
include('security.php');
include('includes/header_mt.php'); 
include('includes/navbar_mt.php'); 

?>
       
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <?php include('includes/topbar.php') ?>
        <!-- End of Topbar -->

        <!-- Modal Add Tour Guide -->
        <div class="modal fade" id="addtourguide" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <style>
                    .modal-content, .form-control {
                        color: black !important; 
                    }
                </style>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Tour Guide</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
      
                    <form action="add_tour_guide.php" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="age">Age:</label>
                                <input type="number" class="form-control" id="age" name="age" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="registerbtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteTourGuideModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this tour guide?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form id="deleteForm" action="delete_tour_guide.php" method="post">
                            <input type="hidden" name="delete_id" id="delete_id">
                            <button type="submit" name="delete_btn" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-2 text-gray-800">Utility > Manage Tour Guide</h1>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtourguide">
                    Add Tour Guide 
                </button>
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

            <?php if (isset($_SESSION['status_ud'])): ?>
                <script>
                    $(document).ready(function() {
                        toastr.success("<?php echo $_SESSION['status_ud']; ?>");
                    });
                </script>
                <?php unset($_SESSION['status_ud']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['status_del'])): ?>
                <script>
                    $(document).ready(function() {
                        toastr.success("<?php echo $_SESSION['status_del']; ?>");
                    });
                </script>
                <?php unset($_SESSION['status_del']); ?>
            <?php endif; ?>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tour Guide List</h6>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <style>
                            .table {
                                color: black !important; 
                            }
                        </style>

                        <?php
                            $query = "SELECT * FROM tour_guide";
                            $query_run = mysqli_query($connection, $query);
                        ?>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                    if(mysqli_num_rows($query_run) > 0) {
                                        while($row = mysqli_fetch_assoc($query_run)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['TourGuideID']; ?></td>
                                        <td><?php echo $row['Name']; ?></td>
                                        <td><?php echo $row['Age']; ?></td>
                                        <td>
                                            <form action="edit_tour_guide.php" method="post">
                                                <input type="hidden" name="edit_id" value="<?php echo $row['TourGuideID']; ?>">
                                                <button type="submit" name="edit_btn" class="btn btn-success">EDIT</button>
                                            </form>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteTourGuideModal" 
                                            data-id="<?php echo $row['TourGuideID']; ?>">DELETE</button>
                                        </td>
                                    </tr>
                                <?php
                                        } 
                                    } else {
                                        echo "No Record Found";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php
        include('includes/footer.php'); 
        include('includes/scripts_mt.php');   
    ?> 

</div>
<!-- End of Page Wrapper --> 

<script>
    // Handle the delete button click
    $('#deleteTourGuideModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var tourGuideId = button.data('id'); 
        var modal = $(this);
        modal.find('#delete_id').val(tourGuideId);
    });
</script>
