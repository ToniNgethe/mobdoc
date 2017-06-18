<nav class="navbar navbar-default navbar-static-top">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= base_url(); ?>">
                <span class="gray">mobdoc</span>
            </a>
        </div>


        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">

                <?php
                if ($this->session->userdata('user_sess')) {
                    $session_data = $this->session->userdata('user_sess');
                    $myid = $session_data['userId'];
                    $myusername = $session_data['username'];
                    $myusergroup = $session_data['usergroup'];



                    $my_details = $this->crudmod->get_record('user', 'userId', $myid);
                    ?>

                    <li class="hidden">
                        <a href="notifications">
                            <i class="glyphicon glyphicon-bell"></i>
                        </a>
                    </li>

                    <li class="dropdown" id="profile">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img alt="" class="avi-rounded-two" src="<?= base_url("avatars/" . $my_details['myavi']); ?>" width="25" height="25">
                            <span class="text-nowrap hidden"><?= $my_details['fullname']; ?></span>
                        </a>
                        <ul class="dropdown-menu"> 
                            <?php
                            if ($myusergroup == 1) {
                                ?>
                                <li>
                                    <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
                                </li>
                                <?php
                            } elseif ($myusergroup == 3) {
                                ?>
                                <li>
                                    <a href="<?= base_url('specialist/dashboard'); ?>">Dashboard</a>
                                </li>
                                <?php
                            }
                            ?>
                            <li>
                                <a href="<?= base_url('patient/medical'); ?>">Medical History</a>
                            </li>
                            <li>
                                <a href="<?= base_url('patient/pastappointments'); ?>">Appointments</a>
                            </li>
                            <li>
                                <a href="<?= base_url('user/profile'); ?>">Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?= base_url('logout'); ?>">Log out</a>
                            </li>
                        </ul>
                    </li>
                    <?php
                } else {
                    ?>

                    <li class="list-practice">
                        <a href="<?= base_url("join/start"); ?>">
                            List your practice on Mobdoc
                        </a>
                    </li>
                    <li class="">
                        <a href="<?= base_url('signin'); ?>">
                            Sign In
                        </a>
                    </li>
                    <li class="">
                        <a href="<?= base_url('create-account'); ?>">
                            Create account
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>