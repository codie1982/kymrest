<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of settings
 *
 * @author engin
 */
class table_application_main_slider extends general {

    public function __construct($table = "") {
        $this->selecttable = "application_main_slider";
        parent::__construct($this->selecttable);
        return true;
    }

    public function get_table_name() {
        return $this->selecttable;
    }

}
