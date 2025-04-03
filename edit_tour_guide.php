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

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-2 text-gray-800">Edit Tour Guide</h1>
            </div>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Tour Guide</h6>
                </div>
                <div class="card-body">
                        <style>
                            .form-group, .form-control {
                                color: black !important; 
                            }
                        </style>
                    <?php
                        if(isset($_POST['edit_btn']))
                            {
                                $id = $_POST['edit_id'];
                                
                                $query = "SELECT * FROM tour_guide WHERE TourGuideID='$id' ";
                                $query_run = mysqli_query($connection, $query);

                                foreach($query_run as $row)
                                    {
                                ?>
                                    <form action="edit_m_tour_guide.php" method="POST">

                                        <input type="hidden" name="edit_id" value="<?php echo $row['TourGuideID'] ?>">

                                        <div class="form-group">
                                            <label> Name: </label>
                                            <input type="text" name="edit_name" value="<?php echo $row['Name'] ?>" class="form-control" autocomplete="off">
                                        </div>

                                        <div class="form-group">
                                            <label> Age: </label>
                                            <input type="number" name="edit_age" value="<?php echo $row['Age'] ?>" class="form-control">
                                        </div>

                                        <a href="manage_tour_guide.php" class="btn btn-danger"> Cancel </a> &ensp;
                                        <button type="submit" name="updatebtn" class="btn btn-primary"> Update </button>
                                    </form>
                            <?php
                           }
                        }
                    ?>    
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
