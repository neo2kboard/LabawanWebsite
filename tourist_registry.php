<?php
include('security.php');
include('includes/header_mt.php'); 
include('includes/navbar_tr.php'); 
?>
       
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <?php include('includes/topbar.php') ?>
        <!-- End of Topbar -->

        <!-- Modal Add Tourist -->
        <div class="modal fade" id="addtourist" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <style>
                    .modal-content, .form-control {
                        color: black !important; 
                    }
                    .modal .select2-dropdown {
                        color: black !important; 
                    }
                    .required {
                        color: red;
                        font-weight: bold;
                    }
                </style>

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Tourist</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
      
                    <form action="add_tourist.php" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">First Name: <span class="required">*</span></label>
                                <input type="text" class="form-control" id="fname" name="fname" required autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="name">Last Name: <span class="required">*</span></label>
                                <input type="text" class="form-control" id="lname" name="lname" required autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="age">Age: <span class="required">*</span></label>
                                <input type="number" class="form-control" id="age" name="age" required>
                            </div>

                            <div class="form-group">
                                <label for="gender">Gender: <span class="required">*</span></label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="" disabled selected>Select Gender</option>
                                            <?php
                                                $query = "SELECT * FROM gender"; // Query to fetch gender data
                                                $query_run = mysqli_query($connection, $query);

                                                    if (mysqli_num_rows($query_run) > 0) {
                                                        while ($row = mysqli_fetch_assoc($query_run)) {
                                                            echo "<option value='" . $row['Gender_ID'] . "'>" . $row['Gender'] . "</option>";
                                                        }
                                                    } else {
                                                            echo "<option value='' disabled>No Gender Available</option>";
                                                    }
                                            ?>
                                    </select>
                            </div>

                            <div class="form-group">
                                <label for="nationality">Nationality: <span class="required">*</span></label>
                                    <select class="form-control select2" id="nationalitySelect" name="nationality" required>
                                        <option value="" disabled selected>Select Nationality</option>
                                            <?php
                                            // List of nationalities with corresponding countries
                                            $nationalities = [
                                                "Afghan (Afghanistan)", "Albanian (Albania)", "Algerian (Algeria)", "Andorran (Andorra)", 
                                                "Angolan (Angola)", "Antiguan (Antigua and Barbuda)", "Argentine (Argentina)", "Armenian (Armenia)", 
                                                "Australian (Australia)", "Austrian (Austria)", "Azerbaijani (Azerbaijan)", "Bahamian (Bahamas)", 
                                                "Bahraini (Bahrain)", "Bangladeshi (Bangladesh)", "Barbadian (Barbados)", "Belarusian (Belarus)", 
                                                "Belgian (Belgium)", "Belizean (Belize)", "Beninese (Benin)", "Bhutanese (Bhutan)", "Bolivian (Bolivia)", 
                                                "Bosnian (Bosnia and Herzegovina)", "Botswanan (Botswana)", "Brazilian (Brazil)", "Bruneian (Brunei)", 
                                                "Bulgarian (Bulgaria)", "Burkinabe (Burkina Faso)", "Burundian (Burundi)", "Cabo Verdean (Cabo Verde)", 
                                                "Cambodian (Cambodia)", "Cameroonian (Cameroon)", "Canadian (Canada)", "Central African (Central African Republic)", 
                                                "Chadian (Chad)", "Chilean (Chile)", "Chinese (China)", "Colombian (Colombia)", "Comorian (Comoros)", "Congolese (Congo)", 
                                                "Costa Rican (Costa Rica)", "Croatian (Croatia)", "Cuban (Cuba)", "Cypriot (Cyprus)", "Czech (Czech Republic)", 
                                                "Democratic Congolese (Democratic Republic of the Congo)", "Danish (Denmark)", "Djiboutian (Djibouti)", 
                                                "Dominican (Dominican Republic)", "Ecuadorian (Ecuador)", "Egyptian (Egypt)", "Salvadoran (El Salvador)", 
                                                "Equatorial Guinean (Equatorial Guinea)", "Eritrean (Eritrea)", "Estonian (Estonia)", "Eswatini (Eswatini)", 
                                                "Ethiopian (Ethiopia)", "Fijian (Fiji)", "Finnish (Finland)", "Filipino (Philippines)", "French (France)", 
                                                "Gabonese (Gabon)", "Gambian (Gambia)", "Georgian (Georgia)", "German (Germany)", "Ghanaian (Ghana)", 
                                                "Greek (Greece)", "Grenadian (Grenada)", "Guatemalan (Guatemala)", "Guinean (Guinea)", 
                                                "Guinea-Bissauan (Guinea-Bissau)", "Guyanese (Guyana)", "Haitian (Haiti)", "Honduran (Honduras)", 
                                                "Hungarian (Hungary)", "Icelander (Iceland)", "Indian (India)", "Indonesian (Indonesia)", "Iranian (Iran)", 
                                                "Iraqi (Iraq)", "Irish (Ireland)", "Israeli (Israel)", "Italian (Italy)", "Jamaican (Jamaica)", 
                                                "Japanese (Japan)", "Jordanian (Jordan)", "Kazakhstani (Kazakhstan)", "Kenyan (Kenya)", "Kiribati (Kiribati)", 
                                                "Korean (North Korea)", "Korean (South Korea)", "Kuwaiti (Kuwait)", "Kyrgyzstani (Kyrgyzstan)", "Laotian (Laos)", 
                                                "Latvian (Latvia)", "Lebanese (Lebanon)", "Lesotho (Lesotho)", "Liberian (Liberia)", "Libyan (Libya)", 
                                                "Liechtensteinian (Liechtenstein)", "Lithuanian (Lithuania)", "Luxembourgish (Luxembourg)", "Macedonian (North Macedonia)", 
                                                "Malagasy (Madagascar)", "Malawian (Malawi)", "Malaysian (Malaysia)", "Maldivian (Maldives)", "Malian (Mali)", 
                                                "Maltese (Malta)", "Marshallese (Marshall Islands)", "Mauritian (Mauritius)", "Mauritanian (Mauritania)", 
                                                "Mexican (Mexico)", "Micronesian (Micronesia)", "Moldovan (Moldova)", "Monacan (Monaco)", "Mongolian (Mongolia)", 
                                                "Montenegrin (Montenegro)", "Moroccan (Morocco)", "Mozambican (Mozambique)", "Burmese (Myanmar)", 
                                                "Namibian (Namibia)", "Nauruan (Nauru)", "Nepalese (Nepal)", "Dutch (Netherlands)", "New Zealander (New Zealand)", 
                                                "Nicaraguan (Nicaragua)", "Nigerien (Niger)", "Nigerian (Nigeria)", "Norwegian (Norway)", "Omani (Oman)", 
                                                "Pakistani (Pakistan)", "Palauan (Palau)", "Panamanian (Panama)", "Papua New Guinean (Papua New Guinea)", 
                                                "Paraguayan (Paraguay)", "Peruvian (Peru)", "Polish (Poland)", "Portuguese (Portugal)", "Qatari (Qatar)", 
                                                "Romanian (Romania)", "Russian (Russia)", "Rwandan (Rwanda)", "Saint Kitts and Nevisian (Saint Kitts and Nevis)", 
                                                "Saint Lucian (Saint Lucia)", "Saint Vincentian (Saint Vincent and the Grenadines)", "Samoan (Samoa)", 
                                                "San Marinese (San Marino)", "Sao Tomean (Sao Tome and Principe)", "Saudi (Saudi Arabia)", "Senegalese (Senegal)", 
                                                "Serbian (Serbia)", "Seychellois (Seychelles)", "Sierra Leonean (Sierra Leone)", "Singaporean (Singapore)", 
                                                "Slovak (Slovakia)", "Slovenian (Slovenia)", "Solomon Islander (Solomon Islands)", "Somali (Somalia)", 
                                                "South African (South Africa)", "South Sudanese (South Sudan)", "Spanish (Spain)", "Sri Lankan (Sri Lanka)", 
                                                "Sudanese (Sudan)", "Surinamese (Suriname)", "Swedish (Sweden)", "Swiss (Switzerland)", "Syrian (Syria)", 
                                                "Taiwanese (Taiwan)", "Tajik (Tajikistan)", "Tanzanian (Tanzania)", "Thai (Thailand)", "Timorese (Timor-Leste)", 
                                                "Togolese (Togo)", "Tongan (Tonga)", "Trinidadian (Trinidad and Tobago)", "Tunisian (Tunisia)", "Turkish (Turkey)", 
                                                "Turkmenistani (Turkmenistan)", "Tuvaluan (Tuvalu)", "Ugandan (Uganda)", "Ukrainian (Ukraine)", "Emirati (United Arab Emirates)", 
                                                "British (United Kingdom)", "American (United States)", "Uruguayan (Uruguay)", "Uzbek (Uzbekistan)", "Vanuatuan (Vanuatu)", 
                                                "Vatican (Vatican City)", "Venezuelan (Venezuela)", "Vietnamese (Vietnam)", "Yemeni (Yemen)", "Zambian (Zambia)", 
                                                "Zimbabwean (Zimbabwe)"
                                            ];

                                            // Loop through the nationalities array and generate <option> for each nationality
                                            foreach ($nationalities as $nationality) {
                                                echo "<option value=\"$nationality\">$nationality</option>";
                                            }
                                        ?>
                                    </select>
                            </div>


                            <div class="form-group">
                                <label for="touristtype">Tourist Type: <span class="required">*</span></label>
                                <select class="form-control" id="touristtype" name="touristtype" required>
                                    <option value="" disabled selected>Select Tourist Type</option>
                                        <?php
                                        // Fetch tourist types from the database
                                            $query = "SELECT * FROM tourist_type";
                                            $query_run = mysqli_query($connection, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    while ($row = mysqli_fetch_assoc($query_run)) {
                                                        echo "<option value='" . $row['TouristTypeID'] . "'>" . $row['Class'] . "</option>";
                                                    }
                                                } else {
                                                        echo "<option value='' disabled>No Tourist Types Available</option>";
                                                }
                                        ?>
                                </select>
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

        <!-- Modal for Delete Confirmation -->
        <div class="modal fade" id="deleteTouristModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Tourist</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this tourist?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-2 text-gray-800">Tour > Tourist Registry</h1>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtourist">
                    Add Tourist 
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
                    <h6 class="m-0 font-weight-bold text-primary">Tourist List</h6>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <style>
                            .table {
                                color: black !important; 
                            }

                        </style>

                        <?php
                            $query = "
                                SELECT t.*, tt.Class, g.Gender
                                FROM tourist t
                                JOIN tourist_type tt ON t.TouristTypeID = tt.TouristTypeID
                                JOIN gender g ON t.GenderID = g.Gender_ID
                            ";
                            $query_run = mysqli_query($connection, $query);
                        ?>

                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Nationality</th>
                                    <th>Tourist Type</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Nationality</th>
                                    <th>Tourist Type</th>
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
                                        <td><?php echo $row['TouristID']; ?></td>
                                        <td><?php echo $row['FirstName']; ?></td>
                                        <td><?php echo $row['LastName']; ?></td>
                                        <td><?php echo $row['Age']; ?></td>
                                        <td><?php echo $row['Gender']; ?></td>
                                        <td><?php echo $row['Nationality']; ?></td>
                                        <td><?php echo $row['Class']; ?></td>
                                        <td>
                                            <form action="edit_tourist.php" method="post">
                                                <input type="hidden" name="edit_id" value="<?php echo $row['TouristID']; ?>">
                                                <button type="submit" name="edit_btn" class="btn btn-success">EDIT</button>
                                            </form>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger delete-btn" data-id="<?php echo $row['TouristID']; ?>" 
                                                data-toggle="modal" data-target="#deleteTouristModal">
                                                DELETE
                                            </button>
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
        include('includes/scripts.php');   
    ?> 


</div>
<!-- End of Page Wrapper --> 

<script src="script.js"></script>


<script>
    $(document).ready(function() {
        // When the delete button is clicked
        $('.delete-btn').click(function() {
            var touristId = $(this).data('id'); // Get the tourist ID from the button's data-id
            $('#confirmDeleteBtn').data('id', touristId); // Store the tourist ID in the modal's delete button
        });

        // When the confirm delete button is clicked
        $('#confirmDeleteBtn').click(function() {
            var touristId = $(this).data('id'); // Retrieve the tourist ID from the button
            window.location.href = "delete_tourist.php?delete_id=" + touristId; // Redirect to delete_tourist.php with the ID
        });
    });
</script>