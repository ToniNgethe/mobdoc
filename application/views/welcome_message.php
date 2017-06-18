
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>Find a Doctor – Doctor Reviews &amp; Ratings | Book Online Instantly – Mobdoc</title>

        <link rel="stylesheet" href="<?= base_url('khyp/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/icons.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/hype.min.css'); ?>">
        <link rel="shortcut icon" href="<?= base_url('khyp/imgs/favicon.png'); ?>">

        <style>
            #mapersLocation {
                height: 400px;
                width: 100%;
            }
        </style>


    </head>
    <body id="main-page">

        <header>

            <?php $this->view('header'); ?>


            <div class="container">
                <div class="search-container">

                    <div class="text-white">
                        <h1 class="home-logo" id="logo">
                            Online self-scheduling lets you check-in for estimated treatment times at Health Care Centers and Clinics or book appointments for healthcare services.
                        </h1>
                    </div>
                </div>
            </div>
        </header>

        


        <div class="search-display">
            <div class="container">
                <div class="row">


                    <div class="col-md-4">
                        <form id="search-form">
                            <label for="zipcode">Location</label>
                            <div class="input-group">
                                <input class="form-search" type="text" value="Nairobi" name="zipcode" id="zipcode" placeholder="e.g. Nairobi"/><span class="input-group-btn">
                                    <button class="btn btn-search-zip" type="submit" id="search-btn">
                                        <i class="i i-search2"></i>
                                    </button>
                                </span>
                            </div>
                            <p class="help-block hidden">Your preferred search or current location.</p>
                        </form>

                        <div id="mapersLocation" class="hidden-xs hidden-sm"></div>


                        <div class="notice-911 hidden-xs hidden-sm">
                            <strong class="important">Mobdoc for specialists</strong>
                            <p>
                                From attracting new patients to reducing no-shows, Mobdoc helps you be the best doctor you can be.
                                <strong class="learn-more"><a href="<?= base_url("join/start"); ?>">Learn More</a></strong></p>
                        </div>
                    </div>



                    <!-- Search results to display here -->
                    <div class="col-md-8">
                        <div class="inventory-filters filter-bar">
                            <label class="hidden-xs hidden-sm">Filters</label>
                            <div>
                                <div class="filter-for specialty">
                                    <label for="specialty" class="hidden">Specialty</label>
                                    <select name="specialty" id="specialty">
                                        <option value="">Specialty</option>
                                        <?php
                                        $all_specialty = $this->crudmod->get_all('specialty', 'specialtyId');
                                        foreach ($all_specialty as $all_specialty_row):
                                            $spe_id = $all_specialty_row->specialtyId;
                                            $spe_name = $all_specialty_row->sName;
                                            ?>
                                            <option value="<?= $spe_id; ?>"><?= $spe_name; ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="next-24-info hidden-xs hidden-sm" style="display: block;">
                            <h5>Available in the Next 24 Hours</h5>
                            <p>Listed below are <strong>Specialists</strong>, <strong>Health Care Centers</strong>, and <strong>Clinics</strong> that have available times
                                in the next 24 hours. Use the location search and specialty to find the right type of care for you.</p>
                        </div>


                        <div class="specialists" id="results">


                        </div>

                    </div>


                </div>
            </div>


        </div>


        <?php $this->view('footer'); ?>


        <script src="<?= base_url('khyp/js/jquery.js'); ?>"></script>
        <script src="<?= base_url('khyp/js/bootstrap.min.js'); ?>"></script>
        <script src="<?= base_url('khyp/js/custom.min.js'); ?>"></script>



    </body>



</html>
