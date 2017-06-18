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
        <title>Mobdoc | System Payments</title>
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
                                                <h3 class="m-b-xs text-black">All my payments</h3> 
                                            </div>
                                        </section>




                                        <div class="pad-content">

                                            <div class="row">
                                                <div class="col-md-12" id="rev">

                                                    <div class="row hidden">
                                                        <div class="col-md-7">
                                                            <div id="session_chart_div" style="height: 100%;"></div>
                                                        </div>
                                                    </div>

                                                    <br/>

                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <p class="help-block hidden">Click on the <strong>accept</strong> button to add a given cover to your profile</p>


                                                            <!-- All payments -->
                                                            <section class="panel panel-default">
                                                                <div class="panel-heading"> All payments made on my specialty </div>
                                                                <div class="table-responsive">

                                                                    <table  id="tblLogs" class="display" width="100%" cellspacing="0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Payee</th>
                                                                                <th>Phone number</th>
                                                                                <th>Appointment ID</th>
                                                                                <th>Amount paid (in KSh.)</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            <?php
                                                                            if (count($payment_details) > 0) {
                                                                                foreach ($payment_details as $payment_details_row):
                                                                                    $my_appointments = $this->crudmod->read_records('appointment', array('appointmentId' => $payment_details_row->appointment_id, 'specialistId' => $userId));
                                                                                    if (count($my_appointments) > 0) {
                                                                                        ?>
                                                                                        <tr class="clickable-row" data-href="">
                                                                                            <td><?= $payment_details_row->payment_id; ?></td>
                                                                                            <td><?= $payment_details_row->first_name.' '.$payment_details_row->last_name; ?></td>
                                                                                            <td><?= $payment_details_row->sender_phone; ?></td>
                                                                                            <td><?= $payment_details_row->appointment_id; ?></td>
                                                                                            <td><?= $payment_details_row->amount; ?></td>
                                                                                        </tr>
                                                                                        <?php
                                                                                    }
                                                                                endforeach;
                                                                            } else {
                                                                                
                                                                            }
                                                                            ?>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <footer class="panel-footer">
                                                                    
                                                                </footer>
                                                            </section>


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
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <!-- Datatables-->
        <script src="<?= base_url("admn/js/datatables/jquery-1.12.4.js"); ?>"></script>
        <script src="<?= base_url("admn/js/datatables/jquery.dataTables.min.js"); ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#tblLogs').DataTable();
            });


        </script>
    </body>

</html>