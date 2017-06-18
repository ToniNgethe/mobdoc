<?php

class Pay extends CI_Controller {

    function payment() {
        $this->load->view('payment');
    }

    function proccess_payment() {
        $transaction_reference = $_POST['transaction_reference'];
        $transaction_timestamp = $_POST['transaction_timestamp'];
        $transaction_type = $_POST['transaction_type'];
        $sender_phone = $_POST['sender_phone'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $amount = $_POST['amount'];

        $payment_details = array(
            'transaction_reference' => $transaction_reference,
            'transaction_timestamp' => $transaction_timestamp,
            'transaction_type' => $transaction_type,
            'sender_phone' => $sender_phone,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'amount' => $amount
        );

        $this->db->insert('payments', $payment_details);
    }

    function confirm() {
        $this->load->view('confirm_payment');
    }

    function process_confirmation() {

        $this->form_validation->set_rules('appKey', 'App Key', 'required|numeric');
        $this->form_validation->set_rules('transactionNumber', 'Transaction Number', 'required|max_length[13]|min_length[13]');
        $this->form_validation->set_rules('transactionCode', 'Transaction Code', 'required|callback_check_payment');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("pay/confirm?refrence=" . $this->input->post('appKey'));
        } else {
            $this->db->where('appointmentId', $this->input->post('appKey'));
            $this->db->update('appointment', array('paymentStatus' => 0));


            $this->db->where('appointment_id', $this->input->post('appKey'));
            $this->db->update('payments', array('completed' => 1));
            redirect("reserve-success?reserve=" . $this->input->post('appKey'));
        }
    }

    function check_payment($transactionCode) {
        $appKey = $this->input->post('appKey');
        $transactionNumber = $this->input->post('transactionNumber');

        $this->db->where('transaction_reference', $transactionCode);
        $this->db->where('sender_phone', $transactionNumber);
        $this->db->update('payments', array('appointment_id' => $appKey));

        $result = $this->crudmod->read_one('appointment', array('appointmentId' => $appKey));
        $billAmount = $this->crudmod->read_one('billing', array('specialistId' => $result['specialistId']));

        $amount_paid = $this->crudmod->read_records('payments', array('transaction_reference' => $transactionCode, 'completed' => FALSE));

        $totalAmount = NULL;

        if (count($amount_paid) > 0) {
            $this->db->select('SUM(amount) as totalPaid');
            $this->db->where('appointment_id', $appKey);
            $this->db->where('completed', FALSE);
            $total_res = $this->db->get('payments')->result();
            foreach ($total_res as $total_row) {
                $totalAmount = $total_row->totalPaid;
            }
        }



        $one = $billAmount['billAmount'];

        $dif = $one - $totalAmount;

        if (count($amount_paid) < 1) {
            $error_string = "The transaction code you have used is incorrect or has already been used in our system. Please make a new payment.";
        } else {
            $error_string = "Amount paid is less than amount required. Pay more KSh. $dif to place your appointment";
        }

        if ($totalAmount >= $billAmount['billAmount']) {

            return TRUE;
        } else {

            $this->form_validation->set_message('check_payment', $error_string);
            return false;
        }
    }

}
