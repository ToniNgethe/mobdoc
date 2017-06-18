<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Review extends CI_Controller {

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

    function writeareview($specialist) {

        if ($this->check_session()) {
            $providerDetails = $this->crudmod->get_where_one_join('user', 'userId', $specialist, 'specialist', 'userId', 'userId');
            foreach ($providerDetails as $row) {
                $displayName = $row->displayName;
                $specialtyPhoto = $row->myavi;
                $qualification = $row->qualification;
                $specialistId = $row->userId;
                $specialtyId = $row->specialtyId;
                $docLocation = $row->zipcode;
                $docPhone = $row->myphone;
                $certificationId = $row->certificationId;
            }

            //Get specialty
            $docSpecialty = $this->crudmod->get_record('specialty', 'specialtyId', $specialtyId);

            //Certification
            $docCertification = $this->crudmod->get_record('certifications', 'certificationId', $certificationId);
            $data = array(
                'displayName' => $displayName,
                'qualification' => $qualification,
                'specialtyPhoto' => $specialtyPhoto,
                'specialistId' => $specialistId,
                'docSpecialty' => $docSpecialty,
                'docLocation' => $docLocation,
                'docPhone' => $docPhone,
                'docCertification' => $docCertification
            );


            $this->load->view('review_view', $data);
        } else {
            redirect('signin');
        }
    }

    function write_review() {

        if ($this->check_session()) {
            $this->form_validation->set_rules('docKey', 'Review Key', 'trim|required|numeric');
            $this->form_validation->set_rules('docReview', 'Review', 'trim|required');


            if ($this->form_validation->run() == FALSE) {
                redirect("writeareview/" . $this->input->post('docKey'));
            } else {

                //Collect and save data
                $docKey = $this->input->post('docKey');
                $docReview = $this->input->post('docReview');

                $this->crudmod->insert('review', array('reviewPublisher' => $this->session_id(), 'reviewTarget' => $docKey, 'reviewContent' => $docReview));

                //Create a log
                $this->crudmod->insert("user_logs", array('userId' => $docKey, 'actor' => $this->session_id(), 'logMessage' => 'Published a review'));

                $this->session->set_flashdata('success', 'Review published successfully');
                redirect("provider/$docKey");
            }
        } else {
            redirect('signin');
        }
    }

}
