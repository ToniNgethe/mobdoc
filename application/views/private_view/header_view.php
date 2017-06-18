<?php
$session_data = $this->session->userdata('user_sess');
$userGroup = $session_data['usergroup'];
$userId = $session_data['userId'];
$my_details = $this->crudmod->get_record('user', 'userId', $userId);
$notifications = $this->crudmod->read_records('notifications', array('notifTo' => $my_details['userId'], 'notifStatus' => FALSE));
?>
<header class="bg-danger header header-md navbar navbar-fixed-top-xs box-shadow">
    <div class="navbar-header aside-md bg-gray">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html"> <i class="i i-slider"></i> </a>
        <a class="navbar-brand">
            <img class="avi-rounded-two m-r-sm" src="<?= base_url("avatars/" . $my_details['myavi']); ?>" width="25" height="25"> 
            <?php
            if ($userGroup == 1) {
                ?>
                <span class="hidden-nav-xs">Admin</span> 
                <?php
            } elseif ($userGroup == 3) {
                ?>
                <span class="hidden-nav-xs">Doctor</span> 
                <?php
            } else {
                ?>
                <span class="hidden-nav-xs">Patient</span> 
                <?php
            }
            ?>
        </a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user"> 
            <i class="i i-chat2"></i>
            <span class="badge badge-sm up bg-info count">
                <?= count($notifications) ?>
            </span>
        </a>
    </div>
    <ul class="nav navbar-nav hidden-xs"> 
        <li class="dropdown">
            <a> 
                <i class="i i-user3"></i> 
                Welcome back <?= $my_details['fullname'];?>
            </a> 
        </li>
    </ul>

    <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
        <li class="">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
                <i class="i i-chat2"></i> 
                <span class="badge badge-sm up bg-danger-ltest text-black count">
                    <?= count($notifications) ?>
                </span>
                Notifications 
            </a>
            <section class="dropdown-menu aside-xl animated slider-vertical">
                <section class="panel bg-white">
                    <div class="panel-heading b-light bg-light">
                        <strong>You have <span class="count"> <?= count($notifications) ?></span> notifications</strong>
                    </div>
                    <div class="list-group list-group-alt">

                        <?php
                        if (count($notifications) > 0) {
                            foreach ($notifications as $notif_row):
                                ?>
                                <a data-href="<?= base_url($notif_row->notifLink); ?>" class="media list-group-item clickable-notif" data-notifid="<?= $notif_row->notifId; ?>"> 
                                    <span class="media-body block m-b-none"> <?= $notif_row->notifMessage; ?>
                                        <br> 
                                        <small class="text-muted"><?= date("d M", strtotime($notif_row->notifTime)); ?> at <?= date("h:m a", strtotime($notif_row->notifTime)); ?></small>
                                    </span>
                                </a>
                                <?php
                            endforeach;
                        } else {
                            ?>
                            <a class="media list-group-item"> 
                                <span class="media-body block m-b-none"> You have no unread notifications</span> 
                            </a>
                            <?php
                        }
                        ?>

                    </div>
                </section>
            </section>
        </li>

        <li>
            <a href="<?= base_url("logout"); ?>">
                <i class="i i-logout"></i> <span class="font-bold">Log out</span>
            </a>
        </li>
    </ul>
</header>
<script type="text/javascript">

</script>