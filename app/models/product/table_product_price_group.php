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
class table_product_price_group extends general {

    public function __construct($all = false) {
        $this->selecttable = "product_price_group";
        parent::__construct($this->selecttable);
    }

    public function get_table_name() {
        return $this->selecttable;
    }

}
