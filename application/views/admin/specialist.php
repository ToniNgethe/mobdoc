<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title> Admin :: Specialist - Mobdoc</title>

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="<?= base_url('khyp/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/icons.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/hype.min.css'); ?>">
        <link rel="shortcut icon" href="<?= base_url('khyp/imgs/favicon.png'); ?>">

    </head>
    <body>


        <?php $this->view('header'); ?>



        <div class="container" id="profile">
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group">
                        <?php
                        $session_data = $this->session->userdata('user_sess');
                        $myusername = $session_data['username'];
                        ?>
                        <a href="<?= base_url('admin/dashboard'); ?>" class="list-group-item">Dashboard</a>
                        <a href="<?= base_url('admin/specialist'); ?>" class="list-group-item active">Specialist</a>
                        <a href="<?= base_url('admin/patient'); ?>" class="list-group-item">Patient</a>
                        <a href="<?= base_url('admin/appointment'); ?>" class="list-group-item">Appointment</a>
                    </div>
                </div>
                <div class="col-md-9" id="rev">

                    <div class="page-header">
                        <h1 class="hidden-sm hidden-xs">
                            <i class="i i-users2"></i> Registered specialists

                            <div class="pull-right hidden-sm hidden-xs user-count"> 
                                Active
                                <!-- Active specialist count -->
                                <span class="badge"><?= count($this->crudmod->get_where_two('user', 'mystatus', 1, 'user_group', 3)); ?></span>
                                Inactive
                                <!-- In-Active/New specialist count -->
                                <span class="badge"><?= count($this->crudmod->get_where_two('user', 'mystatus', 0, 'user_group', 3)); ?></span>
                            </div>
                        </h1>
                    </div>


                    <!-- All inactive/new specialists -->
                    <section class="panel panel-default">
                        <div class="panel-heading"> All inactive/new specialists </div>
                        <div class="table-responsive">
                            <?php
                            $inactive_specialist = $this->crudmod->get_where_two_join('user', 'mystatus', 0, 'user_group', 3, 'specialist', 'userId', 'userId');

                            if (count($inactive_specialist) > 0) {
                                ?>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email address</th>
                                            <th>Registration No.</th>
                                            <th>Specialty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($inactive_specialist as $inactive_specialist_row):
                                            $iid = $inactive_specialist_row->userId;
                                            $iname = $inactive_specialist_row->fullname;
                                            $iemail = $inactive_specialist_row->email;
                                            $iregno = $inactive_specialist_row->registrationNumber;
                                            $ispecialty = $inactive_specialist_row->specialtyId;

                                            $cur_specialty = $this->crudmod->get_record('specialty', 'specialtyId', $ispecialty);
                                            $iSpecialtyName = $cur_specialty['sName'];
                                            ?>
                                            <tr class="clickable-row" data-href="<?= base_url('admin/user?ref=' . $iid); ?>">
                                                <td><?= $iname; ?></td>
                                                <td><?= $iemail; ?></td>
                                                <td><?= $iregno; ?></td>
                                                <td><?= $iSpecialtyName; ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                            } else {
                                
                            }
                            ?>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4 text-center">Found <?= count($this->crudmod->get_where_two_join('user', 'mystatus', 0, 'user_group', 3, 'specialist', 'userId', 'userId')); ?> records</div>
                            </div>
                        </footer>
                    </section>



                    <!-- All active specialists -->
                    <section class="panel panel-default">
                        <div class="panel-heading"> All active specialists </div>
                        <div class="table-responsive">

                            <?php
                            $active_specialist = $this->crudmod->get_where_two_join('user', 'mystatus', 1, 'user_group', 3, 'specialist', 'userId', 'userId');

                            if (count($active_specialist) > 0) {
                                ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email address</th>
                                            <th>Registration No.</th>
                                            <th>Specialty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($active_specialist as $active_specialist_row):
                                            $aid = $active_specialist_row->userId;
                                            $aname = $active_specialist_row->fullname;
                                            $aemail = $active_specialist_row->email;
                                            $aregno = $active_specialist_row->registrationNumber;
                                            $aspecialty = $active_specialist_row->specialtyId;

                                            $cura_specialty = $this->crudmod->get_record('specialty', 'specialtyId', $aspecialty);
                                            $aSpecialtyName = $cura_specialty['sName'];
                                            ?>
                                            <tr class="clickable-row" data-href="<?= base_url('admin/user?ref=' . $aid); ?>">
                                                <td><?= $aname; ?></td>
                                                <td><?= $aemail; ?></td>
                                                <td><?= $aregno; ?></td>
                                                <td><?= $aSpecialtyName; ?></td>
                                        </tr>
                                        <?php
                                    endforeach;
                                    ?>
                                    </tbody>
                                </table>
                                <?php
                            }else {
                                
                            }
                            ?>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4 text-center">Found <?= count($this->crudmod->get_where_two_join('user', 'mystatus', 1, 'user_group', 3, 'specialist', 'userId', 'userId')); ?> records</div>
                            </div>
                        </footer>
                    </section>


                </div>
            </div>
        </div>



        <div class="<?= $show_error; ?>">
            <div class="alert-danger navbar navbar-fixed-bottom">
                <div class="container">
                    <div class="my-error">
                        <strong>Oops! Check the error(s) below :-</strong>
                        <?= $error; ?>
                    </div>
                </div>
            </div>
        </div>


        <?php $this->view('footer'); ?>


        <script src="<?= base_url('khyp/js/jquery.js'); ?>"></script>
        <script src="<?= base_url('khyp/js/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $(".clickable-row").click(function () {
                    window.location = $(this).data("href");
                });
            });
        </script>

    </body>
</html>