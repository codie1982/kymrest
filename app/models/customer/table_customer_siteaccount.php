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
class table_customer_siteaccount extends general {

    public function __construct($all = true) {
        parent::__construct("customer_siteaccount");
        $this->selecttable = "customer_siteaccount";
    }

    public function get_table_name() {
        return $this->selecttable;
    }

}
