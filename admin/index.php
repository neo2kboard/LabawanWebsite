<?php
session_start();

include('includes/header.php');
?>

<!-- Add Google Fonts for Roboto and Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    body {
        background: #cde7ca;
        background-size: cover;
        min-height: 100vh;
    }

    .logo {
        display: block;
        margin: 0 auto 10px auto; 
        max-width: 100px; 
    }

    .arriba-title {
        font-family: 'Roboto', sans-serif; 
        font-weight: bold; 
        font-size: 1.8rem;
        margin-bottom: 20px; 
    }

    .error-message {
        font-family: 'Poppins', sans-serif; 
        font-weight: 500;
        color: #d9534f; 
        font-size: 1rem; 
        margin-bottom: 20px;
        padding: 10px;
        background-color: #f8d7da; 
        border: 1px solid #f5c6cb; 
        border-radius: 5px;
        text-align: center;
        width: 80%; 
        max-width: 400px; 
        margin-left: auto; 
        margin-right: auto; 
    }

   
    .form-control-user {
        font-family: 'Poppins', sans-serif; 
        font-size: 1rem;
        padding: 10px;
        border-radius: 5px !important;
        border: 1px solid #ddd; 
        background-color: #f1f1f1; 
        margin-bottom: 15px;
        width: 80%; 
        max-width: 400px; 
        transition: all 0.3s ease; 
        margin-left: auto;
        margin-right: auto;
    }

    .form-control-user:focus {
        background-color: #fff;
        border-color: #80bdff;
        box-shadow: 0 0 5px rgba(0, 123, 255, .25);
        outline: none;
    }

    .btn-user {
        font-family: 'Poppins', sans-serif; 
        font-weight: 600;
        font-size: 1rem;
        padding: 12px;
        width: 80%; 
        max-width: 400px; 
        border-radius: 5px !important; 
        border: none;
        background-color: #4e73df; 
        color: white;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        margin-left: auto; 
        margin-right: auto;
    }

    .btn-user:hover {
        background-color: #2e59d9; 
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.3);
    }

</style>

<!-- Main Container -->
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center" style="min-height: 100vh; display: flex; justify-content: center; align-items: center;">

        <div class="col-xl-6 col-lg-6 col-md-6">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">

                                    <img src="../img/logo.png" alt="Logo" class="logo">
                                    <h1 class="arriba-title text-gray-900">ARRIBA</h1>

                                    <!-- Display the status message if there is an error -->
                                    <?php
                                        if(isset($_SESSION['status']) && $_SESSION['status'] !='')
                                        {
                                            // Added error message class for styling
                                            echo '<div class="error-message">'.$_SESSION['status'].'</div>';
                                            unset($_SESSION['status']);
                                        }
                                    ?>
                                </div>

                                <form class="user" action="code.php" method="POST">

                                    <div class="form-group">
                                        <input type="email" name="Username" class="form-control form-control-user" placeholder="Enter Email Address...">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="Password" class="form-control form-control-user" placeholder="Password">
                                    </div>

                                    <button type="submit" name="login_btn" class="btn btn-primary btn-user btn-block">Login</button>
                                </form>

                                <hr>
                                <!--
                                <div class="text-center">
                                    <a class="small" href="forgot_pass.php">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="login.html">Create an Account!</a>
                                </div>
                                -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<?php
include('includes/scripts.php');
?>
