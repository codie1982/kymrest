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
class table_customer_adres extends general {

    public function __construct($all = true) {
        parent::__construct("customer_adres");
        $this->selecttable = "customer_adres";
    }

    public function get_table_name() {
        return $this->selecttable;
    }

    public function get_adres_info_from_adresid($adres_id) {
        if ($r = $this->query("SELECT * FROM $this->selecttable WHERE customer_adres_id = ? ", [$adres_id])->one()) {
            $r->primary_key = $this->selecttable . "_id";
            return $r;
        } else {
            return false;
        }
    }

    public function searchAdres($q) {
        $qsef = sef_link($q);
        $_qsef = "%{$qsef}%";
        $r = $this->_db->query("SELECT customer_seccode as id,name as cname FROM $this->selecttable as id WHERE name_sef LIKE ? ", [$_qsef])->results();
        if ($r) {
            return $r;
        } else {
            $r = $this->_db->query("SELECT customer_seccode as id,name as cname FROM $this->selecttable as id WHERE email LIKE ? ", [$_qsef])->results();
            if ($r) {
                return $r;
            } else {
                $r = $this->_db->query("SELECT customer_seccode as id,name as cname FROM $this->selecttable as id WHERE customer_code LIKE ? ", [$_qsef])->results();
                if ($r) {
                    return $r;
                } else {
                    $r = $this->_db->query("SELECT customer_seccode as id,name as cname FROM $this->selecttable as id WHERE customer_idnumber LIKE ? ", [$_qsef])->results();
                    if ($r) {
                        return $r;
                    } else {
                        $r = $this->_db->query("SELECT customer_seccode as id,name as cname FROM $this->selecttable as id WHERE customer_company_tax_number LIKE ? ", [$_qsef])->results();
                        if ($r) {
                            return $r;
                        } else {
                            return false;
                        }
                    }
                }
            }
        }
    }

    public function check_customer_adres($customer_id) {
        $r = $this->query("SELECT COUNT(*) FROM $this->selecttable WHERE customer_id = ? ", [$customer_id])->one();
        return $r->{"COUNT(*)"};
    }

    public function add_new_customer_adres($customer_adres_data) {
        if ($this->insert($customer_adres_data)) {
            return $this->_db->lastinsertID();
        } else {
            return false;
        }
    }

}
