<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Appointment extends CI_Controller {

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

    public function index() {
        
    }

    function bookcheck() {

        $providerId = $this->input->get('professionalId');
        $scheduleId = $this->input->get('startTime');

        $providerDetails = $this->crudmod->get_where_one_join('user', 'userId', $providerId, 'specialist', 'userId', 'userId');
        foreach ($providerDetails as $row) {
            $displayName = $row->displayName;
            $facilityId = $row->facilityId;
            $specialtyPhoto = $row->myavi;
            $qualification = $row->qualification;
            $specialistId = $row->userId;
            $specialtyId = $row->specialtyId;
            $docLocation = $row->zipcode;
            $docPhone = $row->myphone;
        }

        //Get specialty
        $docSpecialty = $this->crudmod->get_record('specialty', 'specialtyId', $specialtyId);


        //Get facility
        if ($facilityId == 0) {
            $facilityClass = "hidden";
        } else {
            $facilityClass = NULL;
        }
        $docFacility = $this->crudmod->get_record('facilities', 'facilityId', $facilityId);

        $data = array(
            'displayName' => $displayName,
            'qualification' => $qualification,
            'specialtyPhoto' => $specialtyPhoto,
            'specialistId' => $specialistId,
            'docSpecialty' => $docSpecialty,
            'docLocation' => $docLocation,
            'docPhone' => $docPhone,
            'facilityClass' => $facilityClass,
            'docFacility' => $docFacility,
            'providerId' => $providerId,
            'scheduleId' => $scheduleId
        );

        $this->load->view('book_check', $data);
    }

    function reserve() {
        $this->form_validation->set_rules('placedBy', 'Placed by Key', 'trim|required');
        $this->form_validation->set_rules('providerKey', 'Provider Key', 'trim|required');
        $this->form_validation->set_rules('scheduleKey', 'Schedule Key', 'trim|required');
        $this->form_validation->set_rules('visitReason', 'Visit Reason', 'required');
        $this->form_validation->set_rules('visitBefore', 'Visited Before', 'trim|required');
        $this->form_validation->set_rules('visitName', 'Full name', 'trim|required');
        $this->form_validation->set_rules('visitEmail', 'Email address', 'trim|required|valid_email');
        $this->form_validation->set_rules('visitPhone', 'Phone number', 'trim|required|numeric');
        $this->form_validation->set_rules('visitLocation', 'Location', 'trim|required');
        $this->form_validation->set_rules('visitOther', 'Other', 'trim');
        $this->form_validation->set_rules('visitBill', 'Bill cover', 'required');
        $this->form_validation->set_rules('visitMore', 'More symptoms', 'trim');



        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'status' => 'false',
                'error' => validation_errors()
            );
            echo json_encode($data);
        } else {

            //Check if fee is charged
            $checkFee = $this->crudmod->get_record('billing', 'specialistId', $this->input->post('providerKey'));
            if ($checkFee['payLater'] == 1) {
                $paymentStatus = 1;
            } elseif ($checkFee['payLater'] == 0) {
                $paymentStatus = 2;
            } else {
                $paymentStatus = 0;
            }

            $appointment_data = array(
                'patientId' => $this->input->post('placedBy'),
                'specialistId' => $this->input->post('providerKey'),
                'timeslotId' => $this->input->post('scheduleKey'),
                'patientName' => $this->input->post('visitName'),
                'patientMobile' => $this->input->post('visitPhone'),
                'patientEmail' => $this->input->post('visitEmail'),
                'patientLocation' => $this->input->post('visitLocation'),
                'visitMainReason' => $this->input->post('visitReason'),
                'visitedBefore' => $this->input->post('visitBefore'),
                'visitOther' => $this->input->post('visitOther'),
                'visitReason' => $this->input->post('visitMore'),
                'insuranceId' => $this->input->post('visitBill'),
                'paymentStatus' => $paymentStatus
            );

            //patient details
            $patientDetails = $this->crudmod->get_record('user', 'userId', $this->input->post('placedBy'));
            $specialistDetails = $this->crudmod->get_record('user', 'userId', $this->input->post('providerKey'));

            $lastappointment = $this->crudmod->insert_id('appointment', $appointment_data);

            //Create a log
            $this->crudmod->insert_id("user_logs", array('userId' => $this->session_id(), 'actor' => $this->session_id(), 'logMessage' => 'Reserved appointment with doctor: ' . $this->input->post('providerKey')));



            if ($lastappointment > 0) {
                //create notif
                $this->crudmod->insert('notifications', array('notifTo' => $this->input->post('providerKey'), 'notifFrom' => $this->session_id(), 'notifMessage' => 'One new appointment request', 'notifLink' => "appointment/detail/$lastappointment"));

                //send email and sms to both patient n doctor
                $mailPatientMessage = "Hello, your appointment at MobDoc has been placed. Wait for the doctor's confirmation via SMS and Email";
                $mailSpecialistMessage = "Hello, a patient reserved an appointment with you. Log in to respond";
                $this->notifymod->send($patientDetails['userId'], $mailPatientMessage, $patientDetails['myphone']);
                $this->notifymod->send($specialistDetails['userId'], $mailSpecialistMessage, $specialistDetails['myphone']);
            }


            //redirect to success and mange page
            if ($checkFee['payLater'] == 1) {

                $red_url = "reserve-success?reserve=$lastappointment";
            } elseif ($checkFee['payLater'] == 0) {

                $red_url = "pay?refrence=$lastappointment";
            } else {

                $red_url = "reserve-success?reserve=$lastappointment";
            }
            $data = array(
                'status' => 'true',
                'red_url' => $red_url
            );
            echo json_encode($data);
        }
    }

    function reserve_success() {
        $reserveKey = $this->input->get('reserve');

        $data = array(
            'reserve' => $reserveKey
        );

        $this->load->view('reserve_success', $data);
    }

    function appointment_details($appointmentKey) {
        $appointmentDetails = $this->crudmod->get_record('appointment', 'appointmentId', $appointmentKey);
        $scheduleDetails = $this->crudmod->get_record('timeslot', 'timeslotId', $appointmentDetails['timeslotId']);
        $this->db->where('patientId', $appointmentDetails['patientId']);
        $this->db->where('appointmentId !=', $appointmentDetails['appointmentId']);
        $passedRecords = $this->db->get('appointment')->result();

        $data = array(
            'appointmentDetails' => $appointmentDetails,
            'passedRecords' => $passedRecords,
            'timeslotDetails' => $scheduleDetails
        );

        $this->load->view('private_view/appointment_detail', $data);
    }

    function reschedule() {

        $this->form_validation->set_rules('edittimeslot', 'Timeslot', 'required');
        $this->form_validation->set_rules('appKey', 'Appointment Key', 'required');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('appointment/detail/' . $this->input->post('appKey'));
        } else {
            $timeslot = $this->input->post('edittimeslot');
            $appKey = $this->input->post('appKey');

            $formated_date = substr($timeslot, 0, 10);
            $formated_time = substr($timeslot, 11, 8);

            $timeslot_data = array(
                'timeslotDate' => $formated_date,
                'timeslotTime' => $formated_time,
                'specialistId' => $this->session_id()
            );

            if (count($this->crudmod->get_where('timeslot', 'timeslotTime', $formated_time)) > 0) {
                $this->db->where('appointmentId', $appKey);
                $update_data = array('appointmentStatus' => 2);
                $this->db->update('appointment', $update_data);
            } else {
                $last_timeslot = $this->crudmod->insert_id('timeslot', $timeslot_data);
                $this->db->where('appointmentId', $appKey);
                $update_data = array('timeslotId' => $last_timeslot, 'appointmentStatus' => 2);
                $this->db->update('appointment', $update_data);
            }

            //Create a log
            $this->crudmod->insert("user_logs", array('userId' => $this->crudmod->get_record("appointment", "appointmentId", $appKey)['patientId'], 'actor' => $this->session_id(), 'logMessage' => 'Rescheduled appointment ID: ' . $appKey));

            //patient details
            $appointmentDetails = $this->crudmod->get_record('appointment', 'appointmentId', $appKey);
            $patientDetails = $this->crudmod->get_record('user', 'userId', $appointmentDetails['patientId']);
            $specialistDetails = $this->crudmod->get_record('specialist', 'userId', $appointmentDetails['specialistId']);

            //create notif
            $this->crudmod->insert('notifications', array('notifTo' => $appointmentDetails['patientId'], 'notifFrom' => $this->session_id(), 'notifMessage' => 'Your appointment has been rescheduled', 'notifLink' => "appointment/detail/$appKey"));



            //send email and sms to both patient n doctor
            $mailPatientMessage = "Hello, your MobDoc appointment with " . $specialistDetails['displayName'] . " has been rescheduled to $formated_date at $formated_time";
            $this->notifymod->send($patientDetails['userId'], $mailPatientMessage, $patientDetails['myphone']);


            $this->session->set_flashdata('success', 'Appointment rescheduled successfully');
            redirect('appointment/detail/' . $appKey);
        }
    }

    function confirm_appointment() {
        $appKey = $this->input->post('appKey');
        $this->db->where('appointmentId', $appKey);
        $update_data = array('appointmentStatus' => 2);
        $this->db->update('appointment', $update_data);

        //Create a log
        $this->crudmod->insert("user_logs", array('userId' => $this->crudmod->get_record("appointment", "appointmentId", $appKey)['patientId'], 'actor' => $this->session_id(), 'logMessage' => 'Confirmed or reactivated appointment ID: ' . $appKey));

        //patient details
        $appointmentDetails = $this->crudmod->get_record('appointment', 'appointmentId', $appKey);
        $patientDetails = $this->crudmod->get_record('user', 'userId', $appointmentDetails['patientId']);
        $specialistDetails = $this->crudmod->get_record('specialist', 'userId', $appointmentDetails['specialistId']);

        //create notif
        $this->crudmod->insert('notifications', array('notifTo' => $appointmentDetails['patientId'], 'notifFrom' => $this->session_id(), 'notifMessage' => 'Your appointment has been confirmed', 'notifLink' => "appointment/detail/$appKey"));


        //send email and sms to both patient n doctor
        $mailPatientMessage = "Hello, your MobDoc appointment with " . $specialistDetails['displayName'] . " has been confirmed";
        $this->notifymod->send($patientDetails['userId'], $mailPatientMessage, $patientDetails['myphone']);



        $this->session->set_flashdata('success', 'Appointment confirmed successfully');

        redirect('appointment/detail/' . $appKey);
    }

    function clear_appointment() {
        $appKey = $this->input->post('appKey');
        $this->db->where('appointmentId', $appKey);
        $update_data = array('appointmentStatus' => 0);
        $this->db->update('appointment', $update_data);

        //Create a log
        $this->crudmod->insert("user_logs", array('userId' => $this->crudmod->get_record("appointment", "appointmentId", $appKey)['patientId'], 'actor' => $this->session_id(), 'logMessage' => 'Cleared appointment ID: ' . $appKey));

        //patient details
        $appointmentDetails = $this->crudmod->get_record('appointment', 'appointmentId', $appKey);
        $patientDetails = $this->crudmod->get_record('user', 'userId', $appointmentDetails['patientId']);
        $specialistDetails = $this->crudmod->get_record('specialist', 'userId', $appointmentDetails['specialistId']);

        //create notif
        $this->crudmod->insert('notifications', array('notifTo' => $appointmentDetails['patientId'], 'notifFrom' => $this->session_id(), 'notifMessage' => 'Your appointment has been cleared', 'notifLink' => "appointment/detail/$appKey"));




        //send email and sms to both patient n doctor
        $mailPatientMessage = "Hello, your MobDoc appointment with " . $specialistDetails['displayName'] . " has been cleared";
        $this->notifymod->send($patientDetails['userId'], $mailPatientMessage, $patientDetails['myphone']);



        $this->session->set_flashdata('success', 'Appointment cleared successfully');

        redirect('appointment/detail/' . $appKey);
    }

    function cancel_appointment() {
        $appKey = $this->input->post('appKey');
        $this->db->where('appointmentId', $appKey);
        $update_data = array('appointmentStatus' => 0);
        $this->db->update('appointment', $update_data);

        //Create a log
        $this->crudmod->insert("user_logs", array('userId' => $this->crudmod->get_record("appointment", "appointmentId", $appKey)['patientId'], 'actor' => $this->session_id(), 'logMessage' => 'Canceled appointment ID: ' . $appKey));

        //patient details
        $appointmentDetails = $this->crudmod->get_record('appointment', 'appointmentId', $appKey);
        $patientDetails = $this->crudmod->get_record('user', 'userId', $appointmentDetails['patientId']);
        $specialistDetails = $this->crudmod->get_record('specialist', 'userId', $appointmentDetails['specialistId']);

        //create notif
        $this->crudmod->insert('notifications', array('notifTo' => $appointmentDetails['patientId'], 'notifFrom' => $this->session_id(), 'notifMessage' => 'Your appointment has been canceled', 'notifLink' => "appointment/detail/$appKey"));



        //send email and sms to both patient n doctor
        $mailPatientMessage = "Hello, your MobDoc appointment with " . $specialistDetails['displayName'] . " has been canceled";
        $this->notifymod->send($patientDetails['userId'], $mailPatientMessage, $patientDetails['myphone']);



        $this->session->set_flashdata('success', 'Appointment canceled successfully');

        redirect('appointment/detail/' . $appKey);
    }

}
