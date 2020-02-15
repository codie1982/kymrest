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
class table_customerlogin extends model {

    private $selecttable;

    public function __construct($all = true) {
        $this->selecttable = "customerlogin";
        parent::__construct($this->selecttable);
    }

    public function get_customer_login_info($customer_id) {
        if ($res = $this->query("SELECT * FROM $this->selecttable WHERE customer_id=?", [$customer_id])->results()) {
            foreach ($res as $r) {
                $r->primary_key = $this->selecttable . "_id";
            }
            return $res;
        } else {
            return false;
        }
    }

    public function insert_data($data) {
        $primary_key = $this->selecttable . "_id";
        if (isset($data[$primary_key])) {
            $pr = $data[$primary_key];
            if ($this->update($pr, $data)) {
                return $data[$primary_key];
            } else {
                return false;
            }
        } else {
            if ($this->insert($data)) {
                return $this->_db->lastinsertID();
            } else {
                return false;
            }
        }
    }

    public function getCustomerLocateByJobID($jobID) {
        if ($r = $this->_db->query("SELECT * FROM $this->selecttable WHERE job_id = ? ", [$jobID])->one()) {
            return $r;
        } else {
            return false;
        }
    }

}
