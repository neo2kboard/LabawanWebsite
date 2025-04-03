<?php
    include('../security.php');
    include('includes/header.php'); 
    include('includes/navbar_g.php');  
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
                <h1 class="h3 mb-2 text-gray-800">Edit Gender</h1>
            </div>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Gender</h6>
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
                                
                                $query = "SELECT * FROM gender WHERE Gender_ID ='$id' ";
                                $query_run = mysqli_query($connection, $query);

                                foreach($query_run as $row)
                                    {
                                ?>
                                    <form action="edit_g_gender.php" method="POST">

                                        <input type="hidden" name="edit_id" value="<?php echo $row['Gender_ID'] ?>">

                                        <div class="form-group">
                                            <label> Tourist Type </label>
                                            <input type="text" name="edit_gender" value="<?php echo $row['Gender'] ?>" class="form-control" autocomplete="off">
                                        </div>

                                        <a href="gender.php" class="btn btn-danger"> Cancel </a> &ensp;
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
        include('includes/scripts.php');   
    ?> 

</div>
<!-- End of Page Wrapper -->
