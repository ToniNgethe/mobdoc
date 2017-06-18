<?php
$session_data = $this->session->userdata('user_sess');
$userGroup = $session_data['usergroup'];
$userId = $session_data['userId'];
$my_details = $this->crudmod->get_record('user', 'userId', $userId);
?>
<!DOCTYPE html>
<html lang="en" class="app">

    <head>
        <meta charset="utf-8" />
        <title>Mobdoc | Insurance</title>
        <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="<?= base_url("admn/css/admin.css"); ?>"/>
    </head>

    <body class="">
       <section class="vbox">
            <!-- .header -->
            <?php $this->load->view('private_view/header_view'); ?>
            <!-- /.header -->
            <section>
                <section class="hbox stretch">


                    <!-- .aside -->
                    <?php $this->load->view('private_view/aside_left'); ?>
                    <!-- /.aside -->



            <section id="content">
                <section class="hbox stretch">
                    <section>
                        <section class="vbox">
                            <section class="scrollable wrapper">
                                <section class="row m-b-md">
                                    <div class="col-sm-6">
                                        <h3 class="m-b-xs text-black">Insurance & Certification</h3> 
                                    </div>
                                </section>



                                <div id="rev">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="help-block">Add a <strong>new insurance cover</strong> which will be available to specialists</p>
                                                <form method="post" action="<?= base_url('save-insurance'); ?>">
                                                    <div class="form-group">
                                                        <label for="insuranceName">Insurance name</label>
                                                        <input type="text" class="form-control" name="insuranceName" id="insuranceName" placeholder="Insurance name" required="true"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <input value="Add insurance" class="btn btn-s-md btn-success" type="submit">
                                                    </div>
                                                </form>

                                                <br/>                         

                                                <!-- All inactive/new specialists -->
                                                <section class="panel panel-default">
                                                    <div class="panel-heading"> Registered insurance covers </div>
                                                    <div class="table-responsive">

                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Name</th>
                                                                    <th>Edit</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                if (count($insurance_covers) > 0) {
                                                                    foreach ($insurance_covers as $insurance_covers_row):
                                                                        $insuranceId = $insurance_covers_row->insuranceId;
                                                                        $insuranceName = $insurance_covers_row->insuranceName;
                                                                        ?>
                                                                        <tr class="clickable-row" data-href="">
                                                                            <td><?= $insuranceId; ?></td>
                                                                            <td><?= $insuranceName; ?></td>
                                                                            <td>
                                                                                <a><i class="i i-pencil"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    endforeach;
                                                                } else {
                                                                    
                                                                }
                                                                ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <footer class="panel-footer">
                                                        <div class="row">
                                                            <div class="col-md-4 col-md-offset-4 text-center">Found <?= count($insurance_covers); ?> records</div>
                                                        </div>
                                                    </footer>
                                                </section>


                                            </div>
                                            
                                            
                                            <div class="col-md-6">
                                                <p class="help-block">Add a <strong>new certification board</strong> which will be used to verify specialists' information</p>
                                                <form method="post" action="<?= base_url('save-certification'); ?>">
                                                    <div class="form-group">
                                                        <label for="certificationName">Certification name</label>
                                                        <input type="text" class="form-control" name="certificationName" id="certificationName" placeholder="Certification name" required="true"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <input value="Add certification" class="btn btn-s-md btn-success" type="submit">
                                                    </div>
                                                </form>

                                                <br/>                         

                                                <!-- All inactive/new specialists -->
                                                <section class="panel panel-default">
                                                    <div class="panel-heading"> Registered certification boards </div>
                                                    <div class="table-responsive">

                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Name</th>
                                                                    <th>Edit</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                if (count($certification_boards) > 0) {
                                                                    foreach ($certification_boards as $certification_boards_row):
                                                                        $certificationId = $certification_boards_row->certificationId;
                                                                        $certificationName = $certification_boards_row->certificationName;
                                                                        ?>
                                                                        <tr class="clickable-row" data-href="">
                                                                            <td><?= $certificationId; ?></td>
                                                                            <td><?= $certificationName; ?></td>
                                                                            <td>
                                                                                <a><i class="i i-pencil"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    endforeach;
                                                                } else {
                                                                    
                                                                }
                                                                ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <footer class="panel-footer">
                                                        <div class="row">
                                                            <div class="col-md-4 col-md-offset-4 text-center">Found <?= count($certification_boards); ?> records</div>
                                                        </div>
                                                    </footer>
                                                </section>


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
                                        
                                </div>

                            </section>
                        </section>
                    </section>

                </section>
                <a href="<?= current_url(); ?>#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
            </section>
        
                </section>
            </section>
        </section>
        <!-- Bootstrap -->
        <!-- App -->
        <script src="<?= base_url("admn/js/admin.js"); ?>"></script>
        <script src="<?= base_url("admn/js/app.plugin.js"); ?>"></script>
        <?php
        if (count($insurance_covers) > 0) {
            foreach ($insurance_covers as $insurance_covers_row):
                $insuranceId = $insurance_covers_row->insuranceId;
                ?>

                <div class="modal fade" id="<?= $insuranceId; ?>insuranceModal" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">×</button>
                                <h4 class="modal-title">Edit <?= $insuranceName; ?></h4>
                            </div>
                            <div class="modal-body">

                            </div>
                            <div class="modal-footer">
                                <a href="" class="btn btn-default" data-dismiss="modal">Close</a> 
                                <a href="" class="btn btn-primary">Save</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
        }
        ?>
    </body>

</html>