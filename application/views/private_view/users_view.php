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
        <title>Mobdoc | System Users</title>
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
                                                <h3 class="m-b-xs text-black">All system users</h3> 
                                            </div>
                                        </section>




                                        <div class="pad-content">

                                            <div class="row">
                                                <div class="col-md-12" id="rev">

                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            <section class="panel panel-default">
                                                                <div class="panel-heading"> User registration summary </div>
                                                                <div id="user-trends"></div>
                                                            </section>
                                                        </div>
                                                        <div class="col-md-5">

                                                            <!-- All inactive/new users -->
                                                            <section class="panel panel-default">
                                                                <div class="panel-heading"> User groups </div>
                                                                <div class="table-responsive">

                                                                    <table  id="tblUserGroups" class="display" width="100%" cellspacing="0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Group name</th>
                                                                                <th>No. of users</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            <?php
                                                                            if (count($usergroups) > 0) {
                                                                                foreach ($usergroups as $usergroups_row):
                                                                                    ?>
                                                                                    <tr class="clickable" data-href="">
                                                                                        <td><?= $usergroups_row->user_group_id ?></td>
                                                                                        <td><?= $usergroups_row->group_name ?></td>
                                                                                        <td><?= count($this->crudmod->read_records('user', array('user_group' => $usergroups_row->user_group_id))) ?></td>
                                                                                    </tr>
                                                                                    <?php
                                                                                endforeach;
                                                                            } else {
                                                                                
                                                                            }
                                                                            ?>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </section>
                                                        </div>
                                                    </div>

                                                    <br/>

                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <p class="help-block hidden">Click on the <strong>accept</strong> button to add a given cover to your profile</p>


                                                            <!-- All inactive/new users -->
                                                            <section class="panel panel-default">
                                                                <div class="panel-heading"> Users </div>
                                                                <div class="table-responsive">

                                                                    <table  id="tblUsers" class="display" width="100%" cellspacing="0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Full name</th>
                                                                                <th>User group</th>
                                                                                <th>Email</th>
                                                                                <th>Phone number</th>
                                                                                <th>Performing user ID</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            <?php
                                                                            if (count($users) > 0) {
                                                                                foreach ($users as $users_row):
                                                                                    ?>
                                                                                    <tr class="clickable-row" data-href="<?= base_url('u/user/'.$users_row->userId) ?>">
                                                                                        <td><?= $users_row->userId; ?></td>
                                                                                        <td><?= $users_row->fullname; ?></td>
                                                                                        <td><?= $this->crudmod->read_one('user_group', array('user_group_id' => $users_row->user_group))['group_name']; ?></td>
                                                                                        <td><?= $users_row->email; ?></td>
                                                                                        <td><?= $users_row->myphone ?></td>
                                                                                        <td><?= $users_row->mystatus == 1 ? "Active" : "Disabled" ?></td>
                                                                                    </tr>
                                                                                    <?php
                                                                                endforeach;
                                                                            } else {
                                                                                
                                                                            }
                                                                            ?>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
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
                $('#tblUsers').DataTable();
                $('#tblUserGroups').DataTable();
            });
        </script>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {packages: ['corechart', 'line']});
            google.charts.setOnLoadCallback(drawCurveTypes);

            function drawCurveTypes() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'X');
                data.addColumn('number', 'Patients');
                data.addColumn('number', 'Specialists');

                data.addRows([
<?php
foreach ($this->db->select("DISTINCT(date(joindate)) as tims")->from('md_user')->order_by('userId asc')->get()->result() as $users) {
    $users_patients = $this->db->select("*")->from('md_user')->where(['date(joindate)' => $users->tims, 'user_group' => 2])->get()->result();
    $users_specialists = $this->db->select("*")->from('md_user')->where(['date(joindate)' => $users->tims, 'user_group' => 3])->get()->result();
    echo "['" . date("M d", strtotime($users->tims)) . "'," . count($users_patients) . ", " . count($users_specialists) . "],";
}
?>
                ]);

                var options = {
                    hAxis: {
                    },
                    vAxis: {
                    }

                };

                var chart = new google.visualization.LineChart(document.getElementById('user-trends'));
                chart.draw(data, options);
            }
        </script>
    </body>

</html>