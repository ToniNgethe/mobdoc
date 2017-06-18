<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Searchmod extends CI_Model {

    function search_specialist($searchKey, $specialistId) {
        $this->db->like('zipcode', $searchKey);
        $this->db->where('specialist.userId !=', $specialistId);
        $this->db->from('specialist');
        $this->db->join('user', 'specialist.userId = user.userId');
        $search_result = $this->db->get();

        return $search_result->result();
    }

    function search_filter($zipcode, $specialty, $specialistId) {
            $this->db->like('zipcode', $zipcode);
        $this->db->where('specialist.userId !=', $specialistId);
            $this->db->where('specialtyId', $specialty);
            $this->db->from('specialist');
            $this->db->join('user', 'specialist.userId = user.userId');
            $search_result = $this->db->get();
        

        return $search_result->result();
    }

    function search_timeslot($table, $column, $value, $columnTwo, $columnThree, $valueThree) {
        $this->db->where($column, $value);
        $this->db->where($columnThree, $valueThree);
        $this->db->order_by($columnTwo, 'asc');
        $res = $this->db->get($table);

        return $res->result();
    }

}
