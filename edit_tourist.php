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

        <link href="path/to/select2.min.css" rel="stylesheet" />
        <script src="path/to/select2.min.js"></script>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-2 text-gray-800">Edit Tourist</h1>
            </div>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Tourist</h6>
                </div>
                <div class="card-body">
                        <style>
                            .form-group, .form-control, .select2-results__option {
                                color: black !important; 
                            }
                            
                        </style>

                    <?php
                        if(isset($_POST['edit_btn']))
                            {
                                $id = $_POST['edit_id'];
                                
                                $query = "
                                    SELECT t.*, tt.Class, g.Gender
                                    FROM tourist t
                                    JOIN tourist_type tt ON t.TouristTypeID = tt.TouristTypeID
                                    JOIN gender g ON t.GenderID = g.Gender_ID WHERE t.TouristID = '$id'
                                ";
                                $query_run = mysqli_query($connection, $query);

                                foreach($query_run as $row)
                                    {
                                ?>
                                    <form action="edit_t_tourist.php" method="POST">

                                        <input type="hidden" name="edit_id" value="<?php echo $row['TouristID'] ?>">

                                        <div class="form-group">
                                            <label> First Name: </label>
                                            <input type="text" name="edit_fname" value="<?php echo $row['FirstName'] ?>" class="form-control" autocomplete="off">
                                        </div>

                                        <div class="form-group">
                                            <label> Last Name: </label>
                                            <input type="text" name="edit_lname" value="<?php echo $row['LastName'] ?>" class="form-control" autocomplete="off">
                                        </div>

                                        <div class="form-group">
                                            <label> Age: </label>
                                            <input type="number" name="edit_age" value="<?php echo $row['Age'] ?>" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Gender:</label>
                                            <select class="form-control" name="edit_gender" required>
                                                <?php
                                                // Get the current gender ID from the tourist record
                                                $current_gender_id = $row['GenderID']; // This is the GenderID from the tourist table

                                                // Query to get all available genders
                                                $gender_query = "SELECT * FROM gender";
                                                $gender_query_run = mysqli_query($connection, $gender_query);
                                                    if (mysqli_num_rows($gender_query_run) > 0) {
                                                        while ($gender_row = mysqli_fetch_assoc($gender_query_run)) {
                                                        $selected = ($gender_row['Gender_ID'] == $current_gender_id) ? "selected" : "";
                                                        echo "<option value='" . $gender_row['Gender_ID'] . "' $selected>" . $gender_row['Gender'] . "</option>";
                                                    }
                                                    } else {
                                                        echo "<option value='' disabled>No Gender Available</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Nationality:</label>
                                                <select class="form-control select2" name="edit_nationality" required>
                                                    <option value="" selected><?php echo $row['Nationality'] ?></option>
                                                        <?php
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
                                                        
                                                            foreach ($nationalities as $nationality) {
                                                                echo "<option value=\"$nationality\">$nationality</option>";
                                                            }
                                                        ?>
                                                </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Tourist Type:</label>
                                                <select class="form-control" name="edit_touristtype" required>
                                                    <option value="" selected><?php echo $row['Class'] ?></option>
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

                                        <a href="tourist_registry.php" class="btn btn-danger"> Cancel </a> &ensp;
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
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%' // Ensures the select box matches the width of other form fields
        });
    });
</script>