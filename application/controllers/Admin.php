<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin extends CI_Controller {

    function check_session() {
        if ($this->session->userdata('user_sess')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function session_id() {
        $session_data = $this->session->userdata('user_sess');
        $userId = $session_data['userId'];

        return $userId;
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

    function index() {

        if ($this->check_session()) {
            $user_details = $this->crudmod->get_where('user', 'userId', $this->session_id());


            $this->load->view('private_view/dashboard', array(
                'user_details' => $user_details
                    )
            );
        } else {
            redirect("signin");
        }
    }

    function users() {
        if ($this->check_session()) {
            $user_details = $this->crudmod->get_where('user', 'userId', $this->session_id());


            $this->load->view('private_view/users_view', array(
                'user_details' => $user_details,
                'users' => $this->crudmod->read_table('user'),
                'usergroups' => $this->crudmod->read_table('user_group')
                    )
            );
        } else {
            redirect("signin");
        }
    }

    function specialist() {

        if ($this->check_session()) {
            $user_details = $this->crudmod->get_where('user', 'userId', $this->session_id());


            $this->load->view('private_view/specialist_view', array(
                'user_details' => $user_details,
                'show_error' => 'hidden',
                'error' => ''
                    )
            );
        } else {
            redirect("signin");
        }
    }

    function view_user($viewed_id) {

        if ($this->check_session()) {

            $user_details = $this->crudmod->get_record('user', 'username', $this->session_username());
            $viewed_user_details = $this->crudmod->get_record('user', 'userId', $viewed_id);


            $this->load->view('private_view/user_details', array(
                'user_details' => $user_details,
                'viewed_id' => $viewed_id,
                'viewed_user' => $viewed_user_details,
                'show_error' => 'hidden',
                'error' => ''));
        } else {
            redirect("signin");
        }
    }

    function patient() {

        if ($this->check_session()) {
            $user_details = $this->crudmod->get_where('user', 'userId', $this->session_id());


            $this->load->view('private_view/patient_view', array(
                'user_details' => $user_details,
                'show_error' => 'hidden',
                'error' => ''
                    )
            );
        } else {
            redirect("signin");
        }
    }

    function appointment() {

        if ($this->check_session()) {
            $username = $this->session_username();

            $user_details = $this->crudmod->get_record('user', 'username', $this->session_username());
            $viewed_user_details = $this->crudmod->get_record('user', 'username', $username);


            $this->load->view('admin/appointment', array('user_details' => $user_details, 'viewed_user' => $viewed_user_details, 'show_error' => 'hidden', 'error' => ''));
        } else {
            redirect("signin");
        }
    }

    function verify_user() {

        //Fetch key details
        $user_key = $this->input->post('user_key');
        $pname = $this->input->post('pname');
        $preg = $this->input->post('preg');
        $pSpec = $this->input->post('pSpec');
        $pCert = $this->input->post('pCert');
        $pphone = $this->input->post('pphone');
        $pemail = $this->input->post('pemail');
        $pstatus = $this->input->post('pstatus');
        $pgroup = $this->input->post('pgroup');

        //Verify
        $verify_data_one = array(
            'fullname' => $pname,
            'verified' => $pstatus,
            'myphone' => $pphone,
            'email' => $pemail,
            'user_group' => $pgroup
        );
        $verify_data_two = array(
            'registrationNumber' => $preg,
            'specialtyId' => $pSpec,
            'certificationId' => $pCert
        );

        //has changed to specialist
        if (count($this->crudmod->read_one('user', array('user_group' => 2, 'userId' => $user_key))) > 0) {
            if ($pgroup == 3) {

                //check if already exist
                if (count($this->crudmod->read_records('specialist', array('userId' => $user_key))) > 0) {
                    $this->db->where('userId', $user_key);
                    $this->db->update('specialist', array('deleted' => FALSE));
                } else {
                    $this->crudmod->insert('specialist', array('userId' => $user_key));
                }
            }
        } elseif (count($this->crudmod->read_one('user', array('user_group' => 3, 'userId' => $user_key))) > 0) {
            $this->crudmod->update_one('specialist', 'userId', $user_key, array('deleted' => FALSE));
        }

        if ($this->crudmod->update_one('user', 'userId', $user_key, $verify_data_one)) {
            //Create a log
            $this->crudmod->insert("user_logs", array('userId' => $user_key, 'actor' => $this->session_id(), 'logMessage' => 'Updated username for account ID: ' . $user_key));

            if ($this->crudmod->update_one('specialist', 'userId', $user_key, $verify_data_two) & $this->session_usergroup() == 3) {
                //Create a log
                $this->crudmod->insert("user_logs", array('userId' => $user_key, 'actor' => $this->session_id(), 'logMessage' => 'Verified details for account ID: ' . $user_key));
            }

            $this->session->set_flashdata('success', 'User details updated successfully');

            redirect('u/user/' . $user_key);
        } else {

            $this->session->set_flashdata('error', 'User details not updated. An error occured. Try again');

            redirect('u/user/' . $user_key);
        }
    }

    function crud_user($action_type) {

        //Fetch key details
        $user_key = $this->input->post('user_key');

        if ($action_type == "activate") {
            //Activate
            $activate_data = array(
                'mystatus' => 1
            );

            if ($this->crudmod->update_one('user', 'userId', $user_key, $activate_data)) {
                //Create a log
                $this->crudmod->insert("user_logs", array('userId' => $user_key, 'actor' => $this->session_id(), 'logMessage' => 'Activated user account ID: ' . $user_key));

                $this->session->set_flashdata('success', 'Account activated successfully');

                redirect('u/user/' . $user_key);
            } else {
                $this->session->set_flashdata('error', 'User details not updated. An error occured. Try again');

                redirect('u/user/' . $user_key);
            }
        } elseif ($action_type == "disable") {
            //Disable
            $disable_data = array(
                'mystatus' => 0
            );

            if ($this->crudmod->update_one('user', 'userId', $user_key, $disable_data)) {
                //Create a log
                $this->crudmod->insert("user_logs", array('userId' => $user_key, 'actor' => $this->session_id(), 'logMessage' => 'Disabled user account ID: ' . $user_key));

                $this->session->set_flashdata('success', 'Account disabled successfully');

                redirect('u/user/' . $user_key);
            } else {
                $this->session->set_flashdata('error', 'User details not updated. An error occured. Try again');

                redirect('u/user/' . $user_key);
            }
        } elseif ($action_type == "delete") {
            //Delete
            $activate_data = array(
                'mystatus' => 2
            );

            if ($this->crudmod->update_one('user', 'userId', $user_key, $activate_data)) {
                //Create a log
                $this->crudmod->insert("user_logs", array('userId' => $user_key, 'actor' => $this->session_id(), 'logMessage' => 'Deleted user account ID: ' . $user_key));

                $this->session->set_flashdata('success', 'Account deleted successfully');

                redirect('u/user/' . $user_key);
            } else {
                $this->session->set_flashdata('error', 'User details not updated. An error occured. Try again');

                redirect('u/user/' . $user_key);
            }
        } else {
            //Not specified
        }
    }

    function insurance() {

        if ($this->check_session()) {
            $user_details = $this->crudmod->get_where('user', 'userId', $this->session_id());

            $insurance_covers = $this->crudmod->get_where('insurance', 'insuranceStatus', 1);
            $certification_boards = $this->crudmod->get_where('certifications', 'certificationDeleted', FALSE);


            $this->load->view('private_view/insurance_view', array(
                'user_details' => $user_details,
                'insurance_covers' => $insurance_covers,
                'certification_boards' => $certification_boards,
                'show_error' => 'hidden',
                'error' => ''
                    )
            );
        } else {
            redirect("signin");
        }
    }

    public function save_insurance() {

        $this->form_validation->set_rules('insuranceName', 'Insurance Name', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'show_error' => "any-error",
                'error' => validation_errors(),
                'insurance_covers' => $this->crudmod->get_where('insurance', 'insuranceStatus', 'insuranceStatus', 1)
            );
            $this->load->view('private_view/insurance_view', $data);
        } else {

            //Collect and save data
            $insuranceName = $this->input->post('insuranceName');

            $lastId = $this->crudmod->insert_id('insurance', array('insuranceName' => $insuranceName, 'createdBy' => $this->session_id()));
            //Create a log
            $this->crudmod->insert("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Added insurance cover ID: ' . $lastId));

            redirect("admin/insurance");
        }
    }

    public function save_certification() {

        $this->form_validation->set_rules('certificationName', 'Certification Name', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'show_error' => "any-error",
                'error' => validation_errors(),
                'certification_boards' => $this->crudmod->get_where('certifications', 'certificationDeleted', FALSE),
                'insurance_covers' => $this->crudmod->get_where('insurance', 'insuranceStatus', 'insuranceStatus', 1)
            );
            $this->load->view('private_view/insurance_view', $data);
        } else {

            //Collect and save data
            $certificationName = $this->input->post('certificationName');

            $lastId = $this->crudmod->insert_id('certifications', array('certificationName' => $certificationName, 'createdBy' => $this->session_id()));
            //Create a log
            $this->crudmod->insert("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Added a certification board ID: ' . $lastId));

            redirect("admin/insurance");
        }
    }

    function all_logs() {
        if ($this->check_session()) {
            $user_details = $this->crudmod->get_where('user', 'userId', $this->session_id());

            $allLogs = $this->crudmod->get_where('user_logs', 'logStatus', 1);


            $this->load->view('private_view/logs_view', array(
                'user_details' => $user_details,
                'allLogs' => $allLogs
                    )
            );
        } else {
            redirect("signin");
        }
    }

    function reports($report = NULL) {


        $date_from = date("Y-m-d");
        $date_to = date("Y-m-d");

        if (isset($_GET['date_from'])) {
            $date_from = date("Y-m-d", strtotime($_GET['date_from']));
        }

        if (isset($_GET['date_to'])) {
            $date_to = date("Y-m-d", strtotime($_GET['date_to']));
        }



        if ($this->check_session()) {
            $user_details = $this->crudmod->get_where('user', 'userId', $this->session_id());

            $allLogs = $this->crudmod->get_where('user_logs', 'logStatus', 1);
            if ($report == "user") {
                $report_data = $this->crudmod->read_records('user', array('mystatus' => TRUE, 'joindate >=' => $date_from . ' 00:00:00', 'joindate <=' => $date_to . ' 23:59:59'));
            } elseif ($report == "appointment") {
                $report_data = $this->crudmod->read_records('appointment', array('appointmentBookTime >=' => $date_from . ' 00:00:00', 'appointmentBookTime <=' => $date_to . ' 23:59:59'));
            }


            $this->load->view('private_view/reports_view', array(
                'user_details' => $user_details,
                'allLogs' => $allLogs,
                'reportType' => $report,
                'reportData' => $report_data
                    )
            );
        } else {
            redirect("signin");
        }
    }

    function filter_appointment($filter_type) {
        $date_from = date("Y-m-d");
        $date_to = date("Y-m-d");

        if (isset($_GET['date_from'])) {
            $date_from = date("Y-m-d", strtotime($_GET['date_from']));
        }

        if (isset($_GET['date_to'])) {
            $date_to = date("Y-m-d", strtotime($_GET['date_to']));
        }



        if ($this->check_session()) {
            $user_details = $this->crudmod->get_where('user', 'userId', $this->session_id());

            $allLogs = $this->crudmod->get_where('user_logs', 'logStatus', 1);
            if ($filter_type == "zipcode") {
                $report_data = $this->crudmod->read_distinct_records('appointment', 'patientLocation', array('appointmentBookTime >=' => $date_from . ' 00:00:00', 'appointmentBookTime <=' => $date_to . ' 23:59:59'));
            } elseif ($filter_type == "symptoms") {
                $report_data = $this->crudmod->read_distinct_records('appointment', 'visitMainReason', array('appointmentBookTime >=' => $date_from . ' 00:00:00', 'appointmentBookTime <=' => $date_to . ' 23:59:59'));
            } elseif ($filter_type == "insurance") {
                $report_data = $this->crudmod->read_distinct_records('appointment', 'insuranceId', array('appointmentBookTime >=' => $date_from . ' 00:00:00', 'appointmentBookTime <=' => $date_to . ' 23:59:59'));
            } else {
                redirect('admin/reports/appointment');
            }


            $this->load->view('tables/filter_appointment', array(
                'user_details' => $user_details,
                'allLogs' => $allLogs,
                'reportType' => $filter_type,
                'reportData' => $report_data
                    )
            );
        } else {
            redirect("signin");
        }
    }

    function specific() {
        $date_from = date("Y-m-d");
        $date_to = date("Y-m-d");

        if (isset($_GET['date_from'])) {
            $date_from = date("Y-m-d", strtotime($_GET['date_from']));
        }

        if (isset($_GET['date_to'])) {
            $date_to = date("Y-m-d", strtotime($_GET['date_to']));
        }

        $report = $_GET['rep'];
        $filter_type = $_GET['fil'];


        if ($this->check_session()) {
            $user_details = $this->crudmod->get_where('user', 'userId', $this->session_id());

            $allLogs = $this->crudmod->get_where('user_logs', 'logStatus', 1);
            if ($report == "app_zip") {
                $report_data = $this->crudmod->read_records('appointment', array('patientLocation' => $filter_type));
            } elseif ($report == "app_sym") {
                $report_data = $this->crudmod->read_records('appointment', array('visitMainReason' => $filter_type));
            } elseif ($report == "app_ins") {
                $report_data = $this->crudmod->read_records('appointment', array('insuranceId' => $filter_type));
            } else {
                redirect('admin/reports/appointment');
            }


            $this->load->view('tables/specific_report', array(
                'user_details' => $user_details,
                'allLogs' => $allLogs,
                'reportType' => $report,
                'reportData' => $report_data
                    )
            );
        } else {
            redirect("signin");
        }
    }

}
