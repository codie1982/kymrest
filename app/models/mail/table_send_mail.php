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
class table_send_mail extends general {

    public function __construct($customer_id = "") {
        parent::__construct("send_mail");
        $this->selecttable = "send_mail";
    }

    public function get_table_name() {
        return $this->selecttable;
    }

}
