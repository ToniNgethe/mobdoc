<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Specialist extends CI_Controller {

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
            $user_details = $this->crudmod->get_record('user', 'username', $this->session_username());


            $this->load->view('private_view/dashboard', array('user_details' => $user_details, 'show_error' => 'hidden', 'error' => ''));
        } else {
            redirect("signin");
        }
    }

    function timeslot() {
        if ($this->check_session()) {
            $user_details = $this->crudmod->get_record('user', 'username', $this->session_username());

            $timeslots = $this->crudmod->get_where_two('timeslot', 'specialistId', $this->session_id(), 'timeslotStatus', 1);


            $this->load->view('private_view/timeslot_view', array('user_details' => $user_details, 'show_error' => 'hidden', 'error' => '', 'timeslots' => $timeslots));
        } else {
            redirect("signin");
        }
    }

    function appointment() {
        if ($this->check_session()) {
            $user_details = $this->crudmod->get_record('user', 'username', $this->session_username());

            $timeslots = $this->crudmod->get_where_two('timeslot', 'specialistId', $this->session_id(), 'timeslotStatus', 1);

            $all_appointments = $this->crudmod->read_records('appointment', array('specialistId' => $this->session_id(), 'appointmentStatus' => 0));

            $this->load->view('private_view/appointment_view', array(
                'user_details' => $user_details,
                'timeslots' => $timeslots,
                'all_appointments' => $all_appointments
            ));
        } else {
            redirect("signin");
        }
    }

    function save_timeslot() {
        $this->form_validation->set_rules('timeslot', 'Timeslot', 'required');
        if ($this->form_validation->run() == false) {
            $this->timeslot();
        } else {
            $timeslot = $this->input->post('timeslot');

            $formated_date = substr($timeslot, 0, 10);
            $formated_time = substr($timeslot, 11, 8);

            $timeslot_data = array(
                'timeslotDate' => $formated_date,
                'timeslotTime' => $formated_time,
                'specialistId' => $this->session_id()
            );

            $lastId = $this->crudmod->insert_id('timeslot', $timeslot_data);
            $this->session->set_flashdata('success', 'Timeslot updated successfully');

            //Create a log
            $this->crudmod->insert("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Added a schedule. ID: ' . $lastId));
        }


        redirect('specialist/schedule');
    }

    function trush_timeslot() {
        $timeslotKey = $this->input->post('timeslotKey');


        //Trush
        $this->db->where('timeslotId', $timeslotKey);
        $this->db->delete('timeslot');
        $this->session->set_flashdata('success', 'Timeslot removed successfully');


        //Create a log
        $this->crudmod->insert("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Removed schedule ID: ' . $timeslotKey));

        redirect('specialist/schedule');
    }

    function billing() {
        if ($this->check_session()) {
            $user_details = $this->crudmod->get_record('user', 'userId', $this->session_id());

            $billing_details = $this->crudmod->get_record('billing', 'specialistId', $this->session_id());


            $this->load->view('private_view/billing_view', array('user_details' => $user_details, 'billing_details' => $billing_details, 'show_error' => 'hidden', 'error' => ''));
        } else {
            redirect("signin");
        }
    }

    public function save_billing() {

        $this->form_validation->set_rules('billAmount', 'Amount', 'trim|required|numeric');
        $this->form_validation->set_rules('billInfo', 'Info', 'trim|required');
        $this->form_validation->set_rules('billWhen', 'When to pay', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $this->billing();
        } else {

            //Collect and save data
            $billAmount = $this->input->post('billAmount');
            $billInfo = $this->input->post('billInfo');
            $billWhen = $this->input->post('billWhen');
            $specialistId = $this->session_id();

            if (count($this->crudmod->get_record('billing', 'specialistId', $this->session_id())) > 0) {
                $this->session->set_flashdata('error', 'You already have an active billing info. Click on edit to make changes');
                $this->billing();
            } else {
                $this->crudmod->insert('billing', array('specialistId' => $specialistId, 'payLater' => $billWhen, 'billAmount' => $billAmount, 'billInfo' => $billInfo));

                //Create a log
                $this->crudmod->insert("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Added billing details'));

                $this->session->set_flashdata('success', 'Billing details updated successfully');
                redirect("specialist/billing");
            }
        }
    }

    public function update_billing() {

        $this->form_validation->set_rules('billAmount', 'Amount', 'trim|required|numeric');
        $this->form_validation->set_rules('billInfo', 'Info', 'trim|required');
        $this->form_validation->set_rules('billWhen', 'When to pay', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $this->billing();
        } else {

            //Collect and save data
            $billAmount = $this->input->post('billAmount');
            $billInfo = $this->input->post('billInfo');
            $billWhen = $this->input->post('billWhen');
            $specialistId = $this->session_id();

            $this->db->where('specialistId', $specialistId);
            $this->db->update('billing', array('payLater' => $billWhen, 'billAmount' => $billAmount, 'billInfo' => $billInfo));

            //Create a log
            $this->crudmod->insert("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Updated billing details'));

            $this->session->set_flashdata('success', 'Billing details updated successfully');
            redirect("specialist/billing");
        }
    }

    public function insurance() {
        if ($this->check_session()) {
            $user_details = $this->crudmod->get_record('user', 'userId', $this->session_id());

            $insurance_covers = $this->crudmod->get_where('insurance', 'insuranceStatus', 1);


            $this->load->view('private_view/insurance_detail', array('user_details' => $user_details, 'insurance_covers' => $insurance_covers, 'show_error' => 'hidden', 'error' => ''));
        } else {
            redirect("signin");
        }
    }

    function accept_insurance() {

        if (count($this->crudmod->read_records('specialist_insurance', array('specialistId' => $this->session_id(), 'insuranceId' => $this->input->post('insurance'), 'specInsStatus' => FALSE))) > 0) {

            //Activate
            $this->db->where('insuranceId', $this->input->post('insurance'));
            $this->db->where('specialistId', $this->session_id());
            $this->db->update('specialist_insurance', array('specInsStatus' => TRUE));
            $this->session->set_flashdata('success', 'Insurance updated successfully');
        } else {

            //insert
            $this->crudmod->insert('specialist_insurance', array('specialistId' => $this->session_id(), 'insuranceId' => $this->input->post('insurance')));

            //Create a log
            $this->crudmod->insert("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Accepted insurance cover ID: ' . $this->input->post('insurance')));

            $this->session->set_flashdata('success', 'Insurance updated successfully');
        }
        redirect('specialist/insurance');
    }

    function remove_insurance() {
        //remove
        $this->db->where('insuranceId', $this->input->post('insurance'));
        $this->db->update('specialist_insurance', array('specInsStatus' => FALSE));

        //Create a log
        $this->crudmod->insert("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Removed insurance cover ID: ' . $this->input->post('insurance')));

        $this->session->set_flashdata('success', 'Insurance removed successfully');
        redirect('specialist/insurance');
    }

    function payments() {
        if ($this->check_session()) {
            $user_details = $this->crudmod->get_record('user', 'userId', $this->session_id());

            $payment_details = $this->crudmod->get_all('payments', 'payment_id');


            $this->load->view('private_view/payments_view', array('user_details' => $user_details, 'payment_details' => $payment_details, 'show_error' => 'hidden', 'error' => ''));
        } else {
            redirect("signin");
        }
    }

    function patients() {
        if ($this->check_session()) {
            $user_details = $this->crudmod->get_record('user', 'username', $this->session_username());

            $all_patients = $this->crudmod->read_group_records('appointment', 'patientId', array('specialistId' => $this->session_id()));

            $this->load->view('private_view/patients', array(
                'user_details' => $user_details,
                'all_patients' => $all_patients
            ));
        } else {
            redirect("signin");
        }
    }

    function patient_details($patientKey) {
        $appointmentDetails = $this->crudmod->read_records('appointment', array('patientId' => $patientKey));
        $patientDetails = $this->crudmod->get_record('user', 'userId', $patientKey);

        $data = array(
            'all_appointments' => $appointmentDetails,
            'patientDetails' => $patientDetails,
        );

        $this->load->view('private_view/patient_detail', $data);
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
            $report_data = $this->crudmod->read_records('appointment', array('specialistId' => $this->session_id(), 'appointmentBookTime >=' => $date_from . ' 00:00:00', 'appointmentBookTime <=' => $date_to . ' 23:59:59'));



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
                $report_data = $this->crudmod->read_distinct_records('appointment', 'patientLocation', array('specialistId' => $this->session_id(), 'appointmentBookTime >=' => $date_from . ' 00:00:00', 'appointmentBookTime <=' => $date_to . ' 23:59:59'));
            } elseif ($filter_type == "symptoms") {
                $report_data = $this->crudmod->read_distinct_records('appointment', 'visitMainReason', array('specialistId' => $this->session_id(), 'appointmentBookTime >=' => $date_from . ' 00:00:00', 'appointmentBookTime <=' => $date_to . ' 23:59:59'));
            } elseif ($filter_type == "insurance") {
                $report_data = $this->crudmod->read_distinct_records('appointment', 'insuranceId', array('specialistId' => $this->session_id(), 'appointmentBookTime >=' => $date_from . ' 00:00:00', 'appointmentBookTime <=' => $date_to . ' 23:59:59'));
            } else {
                redirect('specialist/reports/appointment');
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
                $report_data = $this->crudmod->read_records('appointment', array('specialistId' => $this->session_id(), 'patientLocation' => $filter_type));
            } elseif ($report == "app_sym") {
                $report_data = $this->crudmod->read_records('appointment', array('specialistId' => $this->session_id(), 'visitMainReason' => $filter_type));
            } elseif ($report == "app_ins") {
                $report_data = $this->crudmod->read_records('appointment', array('specialistId' => $this->session_id(), 'insuranceId' => $filter_type));
            } else {
                redirect('specialist/reports/appointment');
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
