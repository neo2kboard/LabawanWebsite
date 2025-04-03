
<?php
    include('../security.php');
    include('includes/header.php'); 
    include('includes/navbar.php'); 
  
 ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include('includes/topbar.php'); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Annual Modal -->
                        <div class="modal fade" id="annualModal" tabindex="-1" role="dialog" aria-labelledby="annualModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="annualModalLabel">Annual Tourists Arrival</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="yearFilter" class="mr-2 text-dark">Select Year:</label>
                                            <input type="number" id="yearFilter" class="form-control w-auto d-inline-block" min="2000" max="2100" placeholder="Enter">

                                            <span style="display: inline-block; width: 20px;"></span> <!-- Add space between elements -->

                                            <label for="touristTypeFilter" class="mr-2 text-dark">Tourist Type:</label>
                                            <input type="text" id="touristTypeFilter" class="form-control w-auto d-inline-block" placeholder="Enter Tourist Type">
                                        </div>


                                        <div class="table-responsive">
                                        <table id="annualTable" class="table table-bordered" width="100%" cellspacing="0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Tourist Type</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-dark">
                                                    <!-- Data will be populated here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Monthly Modal -->
                        <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="infoModalLabel">Monthly Tourists Arrival</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="monthFilter" class="mr-2 text-dark">Select Month:</label> <!-- Darken the label text -->
                                            <select id="monthFilter" class="form-control w-auto d-inline-block">
                                                <option value="01">January</option>
                                                <option value="02">February</option>
                                                <option value="03">March</option>
                                                <option value="04">April</option>
                                                <option value="05">May</option>
                                                <option value="06">June</option>
                                                <option value="07">July</option>
                                                <option value="08">August</option>
                                                <option value="09">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>

                                            <span style="display: inline-block; width: 20px;"></span> <!-- Add space between elements -->

                                            <label for="monthTouristTypeFilter" class="mr-2 text-dark">Tourist Type:</label>
                                            <input type="text" id="monthTouristTypeFilter" class="form-control w-auto d-inline-block" placeholder="Enter Tourist Type">

                                        </div>
                                        <div class="table-responsive">
                                            <table id="modalTable" class="table table-bordered" width="100%" cellspacing="0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Tourist Type</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-dark">
                                                    <!-- Data will be populated here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Daily Tourists Modal -->
                        <div class="modal fade" id="dailyModal" tabindex="-1" role="dialog" aria-labelledby="dailyModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="dailyModalLabel">Tourist Today</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="dateFilter" class="mr-2 text-dark">Select Date:</label> <!-- Darken the label text -->
                                            <input type="date" id="dateFilter" class="form-control w-auto d-inline-block">

                                            <span style="display: inline-block; width: 20px;"></span> <!-- Add space between elements -->

                                            <label for="dailyTouristTypeFilter" class="mr-2 text-dark">Tourist Type:</label>
                                            <input type="text" id="dailyTouristTypeFilter" class="form-control w-auto d-inline-block" placeholder="Enter Tourist Type">

                                        </div>
                                        <div class="table-responsive">
                                            <table id="dailyTable" class="table table-bordered" width="100%" cellspacing="0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Tourist Type</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-dark">
                                                    <!-- Data will be populated here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Annual Tourists Arrival Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2" data-toggle="modal" data-target="#annualModal" id="annualCard">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Annual Tourists Arrival
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Monthly Tourists Arrival Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2" data-toggle="modal" data-target="#infoModal" id="monthlyCard">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Monthly Tourists Arrival</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tourists Today Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2" data-toggle="modal" data-target="#dailyModal" id="dailyCard">
                                <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                 Tourists Today</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Tourist Arrival Analytics</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <!-- Tourist Distribution Card -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Tourist Distribution</h6>
                                </div>
                                <div class="card-body" id="touristDistribution">
                                    <!-- Progress bars will be dynamically added here -->
                                </div>
                            </div>
                        </div>
                    
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-9 mb-4">


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

   
    

    

    

