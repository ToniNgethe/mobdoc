<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Android extends CI_Controller{
    
    
    //Android signup
    function signup(){
        $this->form_validation->set_rules('signusername', 'Username', 'trim|required|is_unique[user.username]');
        $this->form_validation->set_rules('signmail', 'Email address', 'trim|required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('signpassword', 'Password', 'trim|required|min_length[6]');


        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {

            //Collect and save data
            $myusername = $this->input->post('signusername');
            $myemail = $this->input->post('signmail');
            $mypassword = $this->input->post('signpassword');
            $encryptpassword = $this->encrypt->encode($mypassword);

            $lastId = $this->crudmod->insert_id('user', array('fullname' => $myusername, 'user_group' => 2, 'email' => $myemail, 'mypassword' => do_hash($mypassword), 'enpassword' => $encryptpassword, 'mystatus' => 1));

            //Create a log
            $this->crudmod->insert("user_logs", array('userId' => $lastId, 'actor' => $lastId, 'logMessage' => 'Created a patient account'));

            echo "Last inserted ID is $lastId";
        }
    }
    
    function session_id() {
        $session_data = $this->session->userdata('user_sess');
        $myid = $session_data['userId'];

        return $myid;
    }
    
    
    //android login    
    public function login() {
        $this->form_validation->set_rules('logmailorname', 'Email', 'trim|required');
        $this->form_validation->set_rules('logpassword', 'Password', 'trim|required|callback_check_database');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {
            echo $this->session_id();
        }
    }

    function check_database($password) {
        $mymailorname = $this->input->post('logmailorname');

        $result = $this->crudmod->user_login($mymailorname, $password);
        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array(
                    'userId' => $row->userId
                );
                $this->session->set_userdata('user_sess', $sess_array);
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('check_database', "The details you entered did not match our records or your account is inactive. Cross-check and try again.");
            return false;
        }
    }
}