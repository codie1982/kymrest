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
class table_sidebar_menu extends general {

    public function __construct($customer_id = "") {
        parent::__construct("sidebar_menu");
        $this->selecttable = "sidebar_menu";
    }

    public function get_table_name() {
        return $this->selecttable;
    }

}
