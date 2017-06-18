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
        <link rel="stylesheet" href="<?= base_url("admn/css/admin.css"); ?>"/>
        <link href="<?= base_url("admn/js/datatables/jquery.dataTables.min.css"); ?>" rel="stylesheet"/>
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
                                <section class="row m-b-md header-banner">
                                    <div class="col-sm-6">
                                        <h3 class="m-b-xs text-black">Add accepted insurance covers</h3> 
                                    </div>
                                </section>




                                <div class="pad-content">
                                    
                                <div class="row">
                                    <div class="col-md-10" id="rev">

                                        <div class="row">
                                            <div class="col-md-8">

                                                <p class="help-block">Click on the <strong>accept</strong> button to add a given cover to your profile</p>

                                                


                                                <?php if (null != validation_errors() || null != $this->session->flashdata('error') || null != $this->session->flashdata('success')) { ?>
                                                    <div class="alert alert-<?= null == $this->session->flashdata('success') ? 'warning' : 'success' ?>">
                                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                                        <?= validation_errors() ?>
                                                        <?= $this->session->flashdata('error') ?>
                                                        <?= $this->session->flashdata('success') ?>
                                                    </div>
                                                <?php }
                                                ?>

                        

                                                <!-- All inactive/new specialists -->
                                                <section class="panel panel-default">
                                                    <div class="panel-heading"> All insurance covers </div>
                                                    <div class="table-responsive">

                                                        <table  id="tblInsurances" class="display" width="100%" cellspacing="0">
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
                                                                                <?php
                                                                                if (count($this->crudmod->read_records('specialist_insurance', array('specialistId' => $user_details['userId'], 'insuranceId' => $insuranceId, 'specInsStatus' => TRUE))) > 0) {
                                                                                    ?>
                                                                                    <form method="post" action="<?= base_url("remove-insurance"); ?>">
                                                                                        <input type="hidden" name="insurance" id="insurance" value="<?= $insuranceId; ?>"/>
                                                                                        <button class="btn btn-danger btn-xs" type="submit"> 
                                                                                            <span class="text">Remove</span> 
                                                                                        </button>  
                                                                                    </form>
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <form method="post" action="<?= base_url("accept-insurance"); ?>">
                                                                                        <input type="hidden" name="insurance" id="insurance" value="<?= $insuranceId; ?>"/>
                                                                                        <button class="btn btn-success btn-xs" type="submit"> 
                                                                                            <span class="text">Accept</span> 
                                                                                        </button>  
                                                                                    </form>
                                                                                    <?php
                                                                                }
                                                                                ?>

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

        <!-- Datatables-->
        <script src="<?= base_url("admn/js/datatables/jquery-1.12.4.js"); ?>"></script>
        <script src="<?= base_url("admn/js/datatables/jquery.dataTables.min.js"); ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#tblInsurances').DataTable();
            });
        </script>
    </body>

</html>