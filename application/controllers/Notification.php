<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Notification extends CI_Controller {

    function clear_notif() {
        $this->db->where('notifId', $_POST['notif_id']);
        $this->db->update('md_notifications', array('notifStatus' => TRUE));
        $data = array(
            'status' => 'true',
            'red_url' => $_POST['notif_link']
        );
        echo json_encode($data);
    }

}
