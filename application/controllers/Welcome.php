<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {

        $user_details = $this->crudmod->get_record('user', 'username', $this->session_username());


        $data = array(
            'user_details' => $user_details,
            'show_error' => 'hidden',
            'error' => '',
        );

        $this->load->view('welcome_message', $data);
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
    
}
