<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adres
 *
 * @author engin
 */
class table_job_payment extends general {

    public function __construct($all = true) {
        $this->selecttable = "job_payment";
        parent::__construct($this->selecttable);
    }

    public function get_table_name() {
        return $this->selecttable;
    }

}
