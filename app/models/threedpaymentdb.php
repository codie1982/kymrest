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
class threedpaymentdb extends model {

    private $_selecttable;

    public function __construct($all = true) {
        $this->_selecttable = "threedpaymentdb";
        parent::__construct($this->_selecttable);
    }

    public function addthreed($post) {
        $seccode = seccode();
        $fields = ["post" => $post, "payment_seccode" => $seccode, "date" => getNow()];
        if ($this->insert($fields)) {
            return $seccode;
        } else {
            return false;
        }
    }

    public function getthreed($conversition_seccode) {
        if ($r = $this->query("SELECT post FROM $this->_selecttable WHERE payment_seccode=?", [$conversition_seccode])->one()) {
            return json_decode($r->post);
        } else {
            return false;
        }
    }

}
