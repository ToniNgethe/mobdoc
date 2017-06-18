<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Crudmod extends CI_Model {

    function insert($table, $insert_data) {

        $this->db->insert($table, $insert_data);
    }

    function insert_id($table, $insert_data) {

        $this->db->insert($table, $insert_data);
        return $this->db->insert_id();
    }

    function user_login($mynameormail, $mypassword) {
        $this->db->where('email', $mynameormail);
        $this->db->where('mypassword', do_hash($mypassword));
        $this->db->where('mystatus', 1);
        $this->db->limit(1);
        $get_result = $this->db->get('user');
        return $get_result->result();
    }

    function get_record($table, $column, $value) {
        $query = $this->db->get_where($table, array($column => $value));
        return $query->row_array();
    }

    function read_one($table, $paramArray) {
        $query = $this->db->get_where($table, $paramArray);
        return $query->row_array();
    }

    function read_records($table, $paramArray) {
        $this->db->where($paramArray);
        return $this->db->get($table)->result();
    }
    
    function read_table($table) {
        return $this->db->get($table)->result();
    }

    function read_distinct_records($table, $paramDistinct, $paramArray) {
        $this->db->select('DISTINCT(' . $paramDistinct . ')');
        $this->db->where($paramArray);
        return $this->db->get($table)->result();
    }
    
    function read_group_records($table, $paramDistinct, $paramArray) {
        $this->db->group_by($paramDistinct);
        $this->db->where($paramArray);
        return $this->db->get($table)->result();
    }

    function get_all($table, $column) {
        $this->db->order_by($column, 'desc');
        $res = $this->db->get($table);

        return $res->result();
    }

    function get_where_distinct($table, $column, $value) {
        $this->db->select('DISTINCT(timeslotDate)');
        $this->db->where($column, $value);
        $res = $this->db->get($table);

        return $res->result();
    }

    function get_where($table, $column, $value) {
        $this->db->where($column, $value);
        $res = $this->db->get($table);

        return $res->result();
    }

    function get_timeslot($table, $column, $value, $columnTwo, $columnThree, $valueThree) {
        $this->db->where($column, $value);
        $this->db->where($columnThree, $valueThree);
        $this->db->order_by($columnTwo, 'asc');
        $res = $this->db->get($table);

        return $res->result();
    }

    function get_where_two($table, $column, $value, $column_two, $value_two) {
        $this->db->where($column, $value);
        $this->db->where($column_two, $value_two);
        $res = $this->db->get($table);

        return $res->result();
    }

    function get_where_one_join($table, $column, $value, $table_two, $col_one, $col_two) {
        $this->db->where($table . '.' . $column, $value);
        $this->db->from($table);
        $this->db->join($table_two, $table . '.' . $col_one . '=' . $table_two . '.' . $col_two);
        $res = $this->db->get();

        return $res->result();
    }

    function get_where_two_join($table, $column, $value, $column_two, $value_two, $table_two, $col_one, $col_two) {
        $this->db->where($column, $value);
        $this->db->where($column_two, $value_two);
        $this->db->from($table);
        $this->db->join($table_two, $table . '.' . $col_one . '=' . $table_two . '.' . $col_two);
        $res = $this->db->get();

        return $res->result();
    }

    function get_where_three($table, $column, $value, $column_two, $value_two, $column_three, $value_three) {
        $this->db->where($column, $value);
        $this->db->where($column_two, $value_two);
        $this->db->where($column_three, $value_three);
        $res = $this->db->get($table);

        return $res->result();
    }

    function get_where_not($table, $column, $column_two, $value) {
        $this->db->where_not_in($column_two, $value);
        $this->db->order_by($column, 'desc');
        $res = $this->db->get($table);

        return $res->result();
    }

    public function get_search($limit, $start, $q) {
        $this->db->like('username', $q);
        $this->db->or_like('fullname', $q);
        $this->db->from('user');
        $this->db->order_by('userId', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function record_count_search($q) {
        $this->db->like('username', $q);
        $this->db->or_like('fullname', $q);

        return $this->db->count_all("user");
    }

    public function update_one($table, $column, $value, $update_data) {
        $this->db->where($column, $value);
        $this->db->update($table, $update_data);

        return TRUE;
    }

}
