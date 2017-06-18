<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Logsmod extends CI_Model {

    function log_user() {
        $session_data = $this->session->userdata('user_sess');
        $logUserId = $session_data['userId'];
        return $logUserId;
    }

    function appointment_log($type, $specialist) {
        
        //Book appointment
        
        //Reschedule appointment
        
        //Confirm appointment
        
        //Cancel appointment
        
        //Clear appointment
    }

    function user_log($actor, $target, $message){
        
        //Update
        
        //Delete
        
        //Activate
        
        //Disable
        
    }
}
