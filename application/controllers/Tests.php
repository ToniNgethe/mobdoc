<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Tests extends CI_Controller {

    function sample($string) {

        echo $this->unit->run($string, 'is_string');
    }

    function login() {
        
    }

}
