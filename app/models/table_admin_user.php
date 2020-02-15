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
class table_admin_user extends model {

    private $selecttable;

    public function __construct($all = true) {
        $this->selecttable = "admin_user";
        parent::__construct($this->selecttable);
    }

    public function check_admin_user($customer_id) {
        $r = $this->query("SELECT admin_user_id FROM $this->selecttable WHERE customer_id = ? ", [$customer_id])->one();
        if (!empty($r)) {
            return $r->admin_user_id;
        } else {
            return false;
        }
    }

    public function checkAdminUser() {
        $r = $this->query("SELECT COUNT(*) FROM $this->selecttable ", [])->result();
        if ($r) {
            return $r;
        } else {
            return false;
        }
    }

}
