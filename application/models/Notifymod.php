<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Notifymod extends CI_Model {

    function send($mailTo, $mailMessage, $smsPhone) {
        if ($this->emailmod->send_mail($mailTo, $mailMessage)) {
            $this->smsmod->sendSMS($smsPhone, $mailMessage);
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
