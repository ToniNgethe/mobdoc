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
        <title>Mobdoc | Admin:Specialists</title>
        <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
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
                                        <!-- Gather user details -->
                                        <?php
                                        $viewed_user = $this->crudmod->get_record('user', 'userId', $viewed_id);
                                        ?>
                                        <section class="row m-b-md">
                                            <div class="col-sm-6">
                                                <h3 class="m-b-xs text-black"><?= $viewed_user['fullname']; ?>'s profile</h3> 
                                            </div>
                                        </section>

                                        <?php if (null != validation_errors() || null != $this->session->flashdata('error') || null != $this->session->flashdata('success')) { ?>
                                            <div class="alert alert-<?= null == $this->session->flashdata('success') ? 'warning' : 'success' ?>">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <?= validation_errors() ?>
                                                <?= $this->session->flashdata('error') ?>
                                                <?= $this->session->flashdata('success') ?>
                                            </div>
                                        <?php }
                                        ?>



                                        <div class="row">
                                            <div class="col-md-7">
                                                <section class="panel panel-default">
                                                    <header class="panel-heading font-bold">User details</header>
                                                    <div class="panel-body">
                                                        <form method="post" action="<?= base_url("user-verify"); ?>">
                                                            <input type="hidden" name="user_key" value="<?= $viewed_user['userId']; ?>"/>
                                                            <div class="form-group">
                                                                <label for="pname">Name</label>
                                                                <input type="text" class="form-control" name="pname" id="pname" placeholder="e.g. joedoe" required="" value="<?= $viewed_user['fullname']; ?>"/>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="pphone">Phone number</label>
                                                                    <input type="text" class="form-control" name="pphone" id="pphone" placeholder="" required="" value="<?= $viewed_user['myphone']; ?>"/>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="pemail">Email</label>
                                                                    <input type="text" class="form-control" name="pemail" id="pemail" placeholder="" required="" value="<?= $viewed_user['email']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="pstatus">Account status</label>
                                                                    <select class="form-control" autocapitalize="off" autocorrect="off" name="pstatus" id="pstatus">                                        
                                                                        <option selected value="">Select status</option>
                                                                        <?php
                                                                        printf('<option value="%s" %s>%s</option>', 0, 0 == $viewed_user['verified'] ? "selected" : "", "Not verified");
                                                                        printf('<option value="%s" %s>%s</option>', 1, 1 == $viewed_user['verified'] ? "selected" : "", "Verified");
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="">User group</label>
                                                                    <select class="form-control" autocapitalize="off" autocorrect="off" name="pgroup">                                        
                                                                        <option selected value="">Select user group</option>
                                                                        <?php
                                                                        $all_usergroups = $this->crudmod->get_all('user_group', 'user_group_id');
                                                                        foreach ($all_usergroups as $all_usergroups_row):
                                                                            $user_group_id = $all_usergroups_row->user_group_id;
                                                                            $group_name = $all_usergroups_row->group_name;
                                                                            printf('<option value="%s" %s>%s</option>', $user_group_id, $user_group_id == $viewed_user['user_group'] ? "selected" : "", $group_name);
                                                                        endforeach;
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <?php
                                                            if ($viewed_user['user_group'] == 3) {
                                                                $specialist_details = $this->crudmod->get_where('specialist', 'userId', $viewed_user['userId']);
                                                                foreach ($specialist_details as $specialist_details_row) {
                                                                    $regNumber = $specialist_details_row->registrationNumber;
                                                                    $specialty = $specialist_details_row->specialtyId;
                                                                    $certification = $specialist_details_row->certificationId;
                                                                }
                                                                $viewed_specialty = $this->crudmod->get_record('specialty', 'specialtyId', $specialty);
                                                                ?>
                                                                <div class="row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="">Registration Number</label>
                                                                        <input type="text" class="form-control" name="preg" id="" placeholder="e.g. MD894" required="" value="<?= $regNumber; ?>"/>
                                                                        <p class="help-block">Use this for verification on <b>KMB</b></p>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="">Specialty</label>
                                                                        <select class="form-control" autocapitalize="off" autocorrect="off" name="pSpec">                                        
                                                                            <option selected value="">Select Facility type</option>
                                                                            <?php
                                                                            $all_specialties = $this->crudmod->get_all('specialty', 'specialtyId');
                                                                            foreach ($all_specialties as $all_specialties_row):
                                                                                $specialty_id = $all_specialties_row->specialtyId;
                                                                                $sName = $all_specialties_row->sName;
                                                                                printf('<option value="%s" %s>%s</option>', $specialty_id, $specialty == $specialty_id ? "selected" : "", $sName);
                                                                            endforeach;
                                                                            ?>
                                                                        </select>
                                                                        <p class="help-block">Update to match <b>KMB</b> records</p>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Board of certification</label>
                                                                    <select class="form-control" autocapitalize="off" autocorrect="off" name="pCert">                                        
                                                                        <option selected value="">Select board of certification</option>
                                                                        <?php
                                                                        $all_certifications = $this->crudmod->get_all('certifications', 'certificationId');
                                                                        foreach ($all_certifications as $all_certifications_row):
                                                                            $certification_id = $all_certifications_row->certificationId;
                                                                            $certificationName = $all_certifications_row->certificationName;
                                                                            printf('<option value="%s" %s>%s</option>', $certification_id, $certification == $certification_id ? "selected" : "", $certificationName);
                                                                        endforeach;
                                                                        ?>
                                                                    </select>
                                                                    <p class="help-block">Update to match <b>KMB</b> records</p>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                            <div class="form-group">
                                                                <input type="submit" value="Update profile" class="btn btn-s-md btn-success"/>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </section>
                                            </div>
                                            <div class="col-md-5 col-md-offset-0">
                                                <section class="panel panel-default">
                                                    <header class="panel-heading font-bold">More user actions</header>

                                                    <section class="panel clearfix bg-white"> 
                                                        <div class="panel-body"> 
                                                            <a href="#" class="thumb pull-left m-r"> 
                                                                <img src="<?= base_url("avatars/" . $viewed_user['myavi']); ?>" class="img-circle b-a b-3x b-white">
                                                            </a> 
                                                            <div class="clear"> 
                                                                <a href="#" class="text-info">
                                                                    <?= $viewed_user['fullname']; ?>
                                                                </a> 
                                                                <small class="block text-muted">
                                                                    <i class="i i-mail2"></i> <?= $viewed_user['email']; ?>
                                                                </small> 
                                                                <small class="block text-muted">
                                                                    <i class="i i-phone2"></i> <?= $viewed_user['myphone']; ?>
                                                                </small>
                                                                <small class="block text-muted">
                                                                    <i class="i i-calendar"></i> Joined on <?= date("d M y", strtotime($viewed_user['joindate'])); ?>
                                                                </small>  
                                                                <?php
                                                                if ($viewed_user['verified']) {
                                                                    ?>
                                                                    <a class="btn btn-xs btn-success m-t-xs">Verified</a> 
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <a class="btn btn-xs btn-warning m-t-xs">Not Verified</a> 
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div> 
                                                        </div> 
                                                    </section>


                                                    <div class="panel-body" id="user-actions">
                                                        <?= form_open('edit-user/activate'); ?>
                                                        <div class="form-group">
                                                            <input type="hidden" name="user_key" value="<?= $viewed_user['userId']; ?>"/>
                                                            <?php
                                                            if ($viewed_user['mystatus'] != 1) {
                                                                ?>
                                                                <input type="submit" value="Activate account" class="btn btn-s-md btn-success btn-rounded"/>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <input type="submit" value="Account is active" class="btn btn-s-md btn-default btn-rounded disabled"/>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        </form>

                                                        <?= form_open('edit-user/disable'); ?>
                                                        <div class="form-group">
                                                            <input type="hidden" name="user_key" value="<?= $viewed_user['userId']; ?>"/>
                                                            <?php
                                                            if ($viewed_user['mystatus'] == 1) {
                                                                ?>
                                                                <input type="submit" value="Disable account" class="btn btn-s-md btn-warning btn-rounded"/>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <input type="submit" value="Account is disabled" class="btn btn-s-md btn-default btn-rounded disabled"/>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        </form>

                                                        <?= form_open('edit-user/delete'); ?>
                                                        <div class="form-group">
                                                            <input type="hidden" name="user_key" value="<?= $viewed_user['userId']; ?>"/>
                                                            <?php
                                                            if ($viewed_user['mystatus'] != 2) {
                                                                ?>
                                                                <input type="submit" value="Delete account" class="btn btn-s-md btn-danger btn-rounded"/>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <input type="submit" value="Account is deleted" class="btn btn-s-md btn-default btn-rounded disabled"/>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>                                   
                                                        </form>
                                                    </div>
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
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $(".clickable-row").click(function () {
                    window.location = $(this).data("href");
                });
            });
        </script>

    </body>

</html>