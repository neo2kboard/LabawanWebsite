<?php
    include('../security.php');
    include('includes/header.php'); 
    include('includes/navbar_u.php'); 
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
                <h1 class="h3 mb-2 text-gray-800">Edit User</h1>
            </div>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
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
                                
                                $query = "SELECT * FROM users WHERE UserID='$id' ";
                                $query_run = mysqli_query($connection, $query);

                                foreach($query_run as $row)
                                    {
                                ?>
                                    <form action="edit_m_user.php" method="POST">

                                        <input type="hidden" name="edit_id" value="<?php echo $row['UserID'] ?>">

                                        <div class="form-group">
                                            <label> Username: </label>
                                            <input type="text" name="edit_username" value="<?php echo $row['Username'] ?>" class="form-control" autocomplete="off">
                                        </div>

                                        <div class="form-group">
                                            <label> Password: </label>
                                                <div class="input-group">
                                                    <input type="password" id="edit_password" name="edit_password" value="<?php echo $row['Password'] ?>" class="form-control">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="password_toggle">
                                                            <i class="fas fa-eye" id="toggle_icon"></i> 
                                                        </span>
                                                    </div>
                                                </div>
                                        </div>

                                        <div class="form-group">
                                            <label> Role: </label>
                                            <select class="form-control" name="edit_role" required>
                                                <option value="" selected><?php echo $row['Role'] ?></option>
                                                <option value="Admin">Admin</option>
                                                <option value="User">User</option>
                                            </select>
                                        </div>

                                        <a href="manage_users.php" class="btn btn-danger"> Cancel </a> &ensp;
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
