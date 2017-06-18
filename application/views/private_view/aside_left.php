<?php
$session_data = $this->session->userdata('user_sess');
$userGroup = $session_data['usergroup'];
$userId = $session_data['userId'];
$my_details = $this->crudmod->get_record('user', 'userId', $userId);
?>
<aside class="bg-gray aside-md hidden-print hidden-xs" id="nav">
    <section class="vbox">
        <section class="w-f scrollable">
            <!-- nav -->
            <div class=slim-scroll data-height=auto data-disable-fade-out=true data-distance=0 data-size=10px data-railOpacity=0.2>
                <!-- nav -->
                <nav class="nav-primary hidden-xs">

                    <?php
                    if ($userGroup == 1) {
                        ?>

                        <div class="text-muted text-sm hidden-nav-xs padder m-t-sm m-b-sm">MENU</div>
                        <ul class="nav nav-main" data-ride="collapse">

                            <!-- Admin sidebar -->
                            <li>
                                <a href="<?= base_url("admin"); ?>" class="auto"> <i class="i i-statistics icon"> </i> <span class="font-bold">Overview</span> </a>
                            </li>
                            <li>
                                <a href="<?= base_url("admin/users"); ?>" class="auto"> <i class="i i-users2 icon"> </i> <span class="font-bold">Users</span> </a>
                            </li>
                            <li class="hidden">
                                <a href="#" class="auto"> 
                                    <span class="pull-right text-muted"> 
                                        <i class="i i-circle-sm-o text"></i> 
                                        <i class="i i-circle-sm text-active"></i> 
                                    </span> 
                                    <i class="i i-users2 icon"> </i> 
                                    <span class="font-bold">Users</span> 
                                </a>
                                <ul class="nav dk">
                                    <li>
                                        <a href="<?= base_url('admin/specialist'); ?>" class="auto"> <i class="i i-dot"></i> <span>Specialist</span> </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/patient'); ?>" class="auto"> <i class="i i-dot"></i> <span>Patient</span> </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?= base_url("admin/insurance"); ?>" class="auto"> <i class="i i-stack icon"> </i> <span class="font-bold">Insurance & Certification</span> </a>
                            </li>
                            <li>
                                <a href="#" class="auto"> 
                                    <span class="pull-right text-muted"> 
                                        <i class="i i-circle-sm-o text"></i> 
                                        <i class="i i-circle-sm text-active"></i> 
                                    </span> 
                                    <i class="i i-slider-v icon"> </i> 
                                    <span class="font-bold">Reports</span> 
                                </a>
                                <ul class="nav dk">
                                    <li>
                                        <a href="<?= base_url('admin/reports/user'); ?>" class="auto"> <i class="i i-dot"></i> <span>Users</span> </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/reports/appointment'); ?>" class="auto"> <i class="i i-dot"></i> <span>Appointments</span> </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/reports/schedule'); ?>" class="auto hidden"> <i class="i i-dot"></i> <span>Schedules</span> </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?= base_url("admin/logs"); ?>" class="auto"> <i class="i i-switch icon"> </i> <span class="font-bold">System logs</span> </a>
                            </li>
                        </ul>

                        <?php
                    } elseif ($userGroup == 3) {
                        ?>
                        <div class="text-muted text-sm hidden-nav-xs padder m-t-sm m-b-sm">MENU</div>
                        <ul class="nav nav-main" data-ride="collapse">
                            <li>
                                <a href="<?= base_url("admin"); ?>" class="auto"> <i class="i i-statistics icon"> </i> <span class="font-bold">Overview</span> </a>
                            </li>

                            <li>
                                <a href="<?= base_url("specialist/schedule"); ?>">
                                    <i class="i i-clock"></i> <span class="font-bold">Schedules</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url("specialist/appointment"); ?>">
                                    <i class="i i-calendar"></i> <span class="font-bold">Appointment</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url("specialist/patients"); ?>">
                                    <i class="i i-users3"></i> <span class="font-bold">Patients</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="auto"> 
                                    <span class="pull-right text-muted"> 
                                        <i class="i i-circle-sm-o text"></i> 
                                        <i class="i i-circle-sm text-active"></i> 
                                    </span> 
                                    <i class="i i-stack3 icon"> </i> 
                                    <span class="font-bold">Billing</span> 
                                </a>
                                <ul class="nav dk">
                                    <li>
                                        <a href="<?= base_url("specialist/billing"); ?>" class="auto"> <i class="i i-dot"></i> <span>Billing</span> </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('specialist/payments'); ?>" class="auto"> <i class="i i-dot"></i> <span>Payments</span> </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?= base_url("specialist/insurance"); ?>" class="auto"> <i class="i i-stack icon"> </i> <span class="font-bold">Insurance</span> </a>
                            </li>
                            <li>
                                <a href="#" class="auto"> 
                                    <span class="pull-right text-muted"> 
                                        <i class="i i-circle-sm-o text"></i> 
                                        <i class="i i-circle-sm text-active"></i> 
                                    </span> 
                                    <i class="i i-slider-v icon"> </i> 
                                    <span class="font-bold">Reports</span> 
                                </a>
                                <ul class="nav dk">
                                    <li class="hidden">
                                        <a href="<?= base_url('specialist/reports/user'); ?>" class="auto"> <i class="i i-dot"></i> <span>Users</span> </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('specialist/reports/appointment'); ?>" class="auto"> <i class="i i-dot"></i> <span>Appointments</span> </a>
                                    </li>
                                    <li class="hidden">
                                        <a href="<?= base_url('specialist/reports/schedule'); ?>" class="auto"> <i class="i i-dot"></i> <span>Schedules</span> </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Specialist sidebar -->


                        </ul>
                        <?php
                    }
                    ?>




                    <div class="line dk hidden-nav-xs"></div>
                    <div class="text-muted text-xs hidden-nav-xs padder m-t-sm m-b-sm">PROFILE</div>
                    <ul class="nav nav-main"> 
                        <li>
                            <a href="<?= base_url(); ?>">                                
                                <i class="i i-checked"></i> <span class="font-bold">Book Appointment</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('patient/medical'); ?>">                                
                                <i class="i i-health2"></i> <span class="font-bold">Medical History</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('patient/pastappointments'); ?>">
                                <i class="i i-calendar"></i> <span class="font-bold">My Appointments</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('user/profile'); ?>">
                                <i class="i i-cog2"></i> <span class="font-bold">Settings</span>
                            </a>
                        </li>

                    </ul>


                    <div class="line dk hidden-nav-xs"></div>
                    <div class="text-muted text-xs hidden-nav-xs padder m-t-sm m-b-sm">MORE</div>
                    <ul class="nav nav-main">
                        <li>
                            <a href="mailto:help@mobdoc.com"> <i class="i i-question"></i> <span class="font-bold">Need Help?</span> </a>
                        </li>
                    </ul>
                </nav>
                <!-- / nav -->
            </div>
            <!-- / nav -->
        </section>
    </section>
</aside>