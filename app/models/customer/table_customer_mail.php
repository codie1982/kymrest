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
class table_customer_mail extends general {

    public function __construct($all = true) {
        parent::__construct("customer_mail");
        $this->selecttable = "customer_mail";
    }

    public function get_table_name() {
        return $this->selecttable;
    }


}
