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
class table_customer_credi_card extends general {

    public function __construct($all = true) {
        $this->selecttable = "customer_credi_card";
        parent::__construct($this->selecttable);
    }

    public function get_table_name() {
        return $this->selecttable;
    }

}
