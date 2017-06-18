<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User extends CI_Controller {

    function check_session() {
        if ($this->session->userdata('user_sess')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function signup() {

        $this->form_validation->set_rules('signusername', 'Username', 'trim|required|is_unique[user.username]');
        $this->form_validation->set_rules('signmail', 'Email address', 'trim|required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('signpassword', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('signgender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('red', 'Red Value', 'trim|required');


        $red = $this->input->post('red');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'show_error' => "any-error",
                'error' => validation_errors(),
                'red' => $red
            );
            $this->load->view('signup', $data);
        } else {

            //Collect and save data
            $myusername = $this->input->post('signusername');
            $myemail = $this->input->post('signmail');
            $mypassword = $this->input->post('signpassword');
            $mygender = $this->input->post('signgender');
            $encryptpassword = $this->encrypt->encode($mypassword);

            $lastId = $this->crudmod->insert_id('user', array('fullname' => $myusername, 'user_group' => 2, 'gender' => $mygender, 'email' => $myemail, 'mypassword' => do_hash($mypassword), 'enpassword' => $encryptpassword, 'mystatus' => 1));

            //Create session
            $sess_array = array(
                'userId' => $lastId,
                'username' => $myusername,
                'usergroup' => 2
            );
            $this->session->set_userdata('user_sess', $sess_array);

            //Create a log
            $this->crudmod->insert("user_logs", array('userId' => $lastId, 'actor' => $lastId, 'logMessage' => 'Created a patient account'));

            redirect($red);
        }
    }

    public function practice_join() {

        $this->form_validation->set_rules('specname', 'Full name', 'trim|required');
        $this->form_validation->set_rules('specemail', 'Email address', 'trim|required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('specregno', 'Registration', 'trim|required|max_length[10]');
        $this->form_validation->set_rules('specspecialty', 'Specialty', 'trim|required');
        $this->form_validation->set_rules('specpassword', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('specphone', 'Phone number', 'trim|required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'show_error' => "any-error",
                'error' => validation_errors()
            );
            $this->load->view('listpractice', $data);
        } else {

            //Collect and save data
            $specname = $this->input->post('specname');
            $specemail = $this->input->post('specemail');
            $specregno = $this->input->post('specregno');
            $specspecialty = $this->input->post('specspecialty');
            $specspassword = $this->input->post('specpassword');
            $specphone = $this->input->post('specphone');
            $encryptpassword = $this->encrypt->encode($specspassword);

            $lastId = $this->crudmod->insert_id('user', array('fullname' => $specname, 'user_group' => 3, 'email' => $specemail, 'myphone' => $specphone, 'mypassword' => do_hash($specspassword), 'enpassword' => $encryptpassword));
            $this->crudmod->insert('specialist', array('userId' => $lastId, 'registrationNumber' => $specregno, 'specialtyId' => $specspecialty));


            //Create a log
            $this->crudmod->insert("user_logs", array('userId' => $lastId, 'actor' => $lastId, 'logMessage' => 'Listed his/her practice'));

            redirect('join/thanks?u=' . $lastId);
        }
    }

    public function thanks() {
        $username = $this->input->get('u');

        $data = array(
            'show_error' => "hidden",
            'error' => "",
            'user' => $username
        );

        $this->load->view('thanks', $data);
    }

    public function login() {
        $this->form_validation->set_rules('logmailorname', 'Email', 'trim|required');
        $this->form_validation->set_rules('logpassword', 'Password', 'trim|required|callback_check_database');
        $this->form_validation->set_rules('red', 'Red Value', 'trim|required');


        $red = $this->input->post('red');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'show_error' => "any-error",
                'error' => validation_errors(),
                'red' => $red
            );
            $this->load->view('signin', $data);
        } else {


            //Create a log
            $this->crudmod->insert("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Logged into the system'));

            if ($this->session_usergroup() == 2) {
                redirect($red);
            } else {
                redirect('admin/dashboard');
            }
        }
    }

    function check_database($password) {
        $mymailorname = $this->input->post('logmailorname');

        $result = $this->crudmod->user_login($mymailorname, $password);
        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array(
                    'userId' => $row->userId,
                    'username' => $row->username,
                    'usergroup' => $row->user_group
                );
                $this->session->set_userdata('user_sess', $sess_array);
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('check_database', "The details you entered did not match our records or your account is inactive. Cross-check and try again.");
            return false;
        }
    }

    function session_id() {
        $session_data = $this->session->userdata('user_sess');
        $myid = $session_data['userId'];

        return $myid;
    }

    function session_username() {
        $session_data = $this->session->userdata('user_sess');
        $myusername = $session_data['username'];

        return $myusername;
    }

    function session_usergroup() {
        $session_data = $this->session->userdata('user_sess');
        $myusergroup = $session_data['usergroup'];

        return $myusergroup;
    }

    function logout() {

        //Create a log
        $this->crudmod->insert("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Logged out of the system'));


        $this->session->unsetuserdata['user_sess'];
        $this->session->sess_destroy();

        redirect(base_url('home'));
    }

    function profile() {

        $username = $this->session_username();

        $user_details = $this->crudmod->get_record('user', 'username', $this->session_username());
        $viewed_user_details = $this->crudmod->get_record('user', 'username', $username);

        $this->load->view('profile', array('user_details' => $user_details, 'viewed_user' => $viewed_user_details, 'show_error' => 'hidden', 'error' => ''));
    }

    function history() {


        if ($this->check_session()) {
            $user_details = $this->crudmod->get_record('user', 'username', $this->session_id());


            $this->load->view('history', array('user_details' => $user_details, 'show_error' => 'hidden', 'error' => ''));
        } else {
            redirect('signin');
        }
    }

    function profile_settings() {
        if ($this->check_session()) {
            $user_details = $this->crudmod->get_record('user', 'userId', $this->session_id());
            $this->load->view('settings', array('user_details' => $user_details, 'show_error' => 'hidden', 'error' => ''));
        } else {
            redirect('signin');
        }
    }

    function account_settings() {
        if ($this->check_session()) {
            $user_details = $this->crudmod->get_record('user', 'userId', $this->session_id());
            $this->load->view('settings_account', array('user_details' => $user_details, 'show_error' => 'hidden', 'error' => ''));
        } else {
            redirect('signin');
        }
    }

    function mobile_settings() {
        if ($this->check_session()) {
            $user_details = $this->crudmod->get_record('user', 'userId', $this->session_id());
            $this->load->view('settings_mobile', array('user_details' => $user_details, 'show_error' => 'hidden', 'error' => ''));
        } else {
            redirect('signin');
        }
    }

    function social_settings() {
        if ($this->check_session()) {
            $user_details = $this->crudmod->get_record('user', 'userId', $this->session_id());
            $this->load->view('settings_social', array('user_details' => $user_details, 'show_error' => 'hidden', 'error' => ''));
        } else {
            redirect('signin');
        }
    }

    function update_profesional() {
        $qualification = $this->input->post('specqualification');
        $displayName = $this->input->post('specdisplayname');
        $doctorFacility = $this->input->post('specFacility');

        $data = array(
            'qualification' => $qualification,
            'displayName' => $displayName,
            'facilityId' => $doctorFacility
        );

        $this->db->where('userId', $this->session_id());
        $this->db->update('specialist', $data);


        //Create a log
        $this->crudmod->insert("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Updated proffessional details'));

        redirect('user/profile');
    }

    function update_profile() {
        $name = $this->input->post('pname');
        $zip = $this->input->post('pzip');
        $gender = $this->input->post('pgender');

        $data = array(
            'fullname' => $name,
            'zipcode' => $zip,
            'gender' => $gender
        );

        $this->db->where('userId', $this->session_id());
        $this->db->update('user', $data);


        //Create a log
        $this->crudmod->insert("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Updated personal details'));


        redirect('user/profile');
    }

    public function do_upload() {
        $config['upload_path'] = './avatars/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 1000;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')) {
            $user_details = $this->crudmod->get_record('user', 'userId', $this->session_id());
            $data = array(
                'user_details' => $user_details,
                'show_error' => "any-error",
                'error' => $this->upload->display_errors()
            );
            $this->load->view('settings', $data);
        } else {

            $data = array(
                'myavi' => $this->upload->data('file_name')
            );

            $this->db->where('username', $this->session_username());
            $this->db->where('userId', $this->session_id());
            $this->db->update('user', $data);


            //Create a log
            $this->crudmod->insert("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Updated profile picture'));


            redirect('user/profile');
        }
    }

    function reset_password() {
        if ($this->check_session()) {
            redirect(base_url());
        } else {
            $data = array(
                'show_error' => 'hidden',
                'error' => ''
            );

            $this->load->view('password_reset', $data);
        }
    }

    public function signin() {
        if ($this->check_session()) {
            redirect(base_url());
        } else {
            $data = array(
                'show_error' => 'hidden',
                'error' => '',
                'red' => 'patient/medical'
            );

            $this->load->view('signin', $data);
        }
    }

    function create_account() {
        if ($this->check_session()) {
            redirect(base_url());
        } else {
            $data = array(
                'show_error' => 'hidden',
                'error' => '',
                'red' => 'patient/medical'
            );

            $this->load->view('signup', $data);
        }
    }

    function join_practice() {
        $data = array(
            'show_error' => 'hidden',
            'error' => ''
        );

        $this->load->view('listpractice', $data);
    }

    public function update_username() {

        $this->form_validation->set_rules('pusername', 'Username', 'trim|required|is_unique[user.username]');

        if ($this->form_validation->run() == FALSE) {


            if ($this->session_username() == $this->input->post('pusername')) {
                redirect('settings/account');
            } else {
                $user_details = $this->crudmod->get_record('user', 'username', $this->input->post('ru'));
                $data = array(
                    'user_details' => $user_details,
                    'show_error' => "any-error",
                    'error' => validation_errors()
                );
                $this->load->view('settings_account', $data);
            }
        } else {

            //Collect and save data
            $pusername = $this->input->post('pusername');

            $this->db->where('userId', $this->session_id());
            $this->db->update('user', array('username' => $pusername));

            $sess_array = array('myid' => $this->session_id(), 'username' => $pusername, 'usergroup' => $this->session_usergroup());
            $this->session->set_userdata('user_sess', $sess_array);


            redirect('settings/account');
        }
    }

    public function update_password() {

        $this->form_validation->set_rules('pold', 'Old password', 'trim|required|callback_check_oldpassword');
        $this->form_validation->set_rules('pnew', 'New password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('pconfirm', 'Confirm new password', 'trim|required|matches[pnew]');

        if ($this->form_validation->run() == FALSE) {

            $user_details = $this->crudmod->get_record('user', 'username', $this->input->post('ru'));
            $data = array(
                'user_details' => $user_details,
                'show_error' => "any-error",
                'error' => validation_errors()
            );
            $this->load->view('settings_account', $data);
        } else {

            //Collect and save data
            $pnew = $this->input->post('pnew');

            $this->db->where('userId', $this->session_id());
            $this->db->update('user', array('mypassword' => do_hash($pnew)));


            //Create a log
            $this->crudmod->insert("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Updated password details'));


            redirect('settings/account');
        }
    }

    function check_oldpassword($password) {
        $old_password_details = $this->crudmod->get_record('user', 'userId', $this->session_id());
        $old_password = $old_password_details['mypassword'];

        if (do_hash($password) == $old_password) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_oldpassword', "The old password you submitted is incorrect. Cross-check and try again.");
            return false;
        }
    }

    public function update_delete() {

        $this->db->delete('user', array('userId' => $this->session_id()));
        $this->db->delete('review', array('rev_target' => $this->session_id()));
        $this->db->delete('review', array('rev_publisher' => $this->session_id()));
        $this->db->delete('feed', array('fee_target' => $this->session_id()));
        $this->db->delete('feed', array('fee_from' => $this->session_id()));
        $this->db->delete('job', array('published_by' => $this->session_id()));


        redirect('logout');
    }

    public function update_phone() {

        $this->form_validation->set_rules('pmobile', 'Mobile phone number', 'trim|required|is_unique[user.myphone]');

        $old_phone_details = $this->crudmod->get_record('user', 'userId', $this->session_id());
        $my_phone = $old_phone_details['myphone'];

        if ($this->form_validation->run() == FALSE) {


            if ($my_phone == $this->input->post('pmobile')) {
                redirect('settings/mobile');
            } else {
                $user_details = $this->crudmod->get_record('user', 'username', $this->input->post('ru'));
                $data = array(
                    'user_details' => $user_details,
                    'show_error' => "any-error",
                    'error' => validation_errors()
                );
                $this->load->view('settings_mobile', $data);
            }
        } else {

            //Collect and save data
            $pmobile = $this->input->post('pmobile');

            $this->db->where('userId', $this->session_id());
            $this->db->update('user', array('myphone' => $pmobile));



            //Create a log
            $this->crudmod->insert("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Updated mobile details'));


            redirect('settings/mobile');
        }
    }

    function appointment_dash() {

        if ($this->check_session()) {

            $user_details = $this->crudmod->get_record('user', 'userId', $this->session_id());

            $this->load->view('appointment', array('user_details' => $user_details, 'show_error' => 'hidden', 'error' => ''));
        } else {
            redirect("signin");
        }
    }

}
