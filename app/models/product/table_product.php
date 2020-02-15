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
class table_product extends general {

    private $_category_list = array();
    private $_product_list = array();

    public function __construct($all = true) {
        $this->selecttable = "product";
        parent::__construct($this->selecttable);
    }

    public function set_category_list($val = array()) {
        $this->_category_list = $val;
    }

    public function set_product_list($val = array()) {
        $this->_product_list = $val;
    }

    public function get_table_name() {
        return $this->selecttable;
    }

//    public function get_data($primary_id = null) {
//        $prm = $this->selecttable . "_id";
//        if (is_null($primary_id)) {
//            $sql = "SELECT * FROM $this->selecttable ORDER BY $prm DESC LIMIT 1";
//            $arr = [];
//        } else {
//            $sql = "SELECT * FROM $this->selecttable WHERE $prm = ?";
//            $arr = [$primary_id];
//        }
//        if ($r = $this->query($sql, $arr)->one()) {
//            $r->primary_key = $prm;
//            return $r;
//        } else {
//            return false;
//        }
//    }
//
//    public function get_data_main_key($product_id) {
//        $prm = $this->selecttable . "_id";
//        if ($res = $this->query("SELECT * FROM $this->selecttable WHERE product_id=?", [$product_id])->results()) {
//            foreach ($res as $r) {
//                $r->primary_key = $prm;
//            }
//            return $res;
//        } else {
//            return false;
//        }
//    }
//
//    public function insert_data($data) {
//        $primary_key = $this->selecttable . "_id";
//        if (isset($data[$primary_key])) {
//            $pr = $data[$primary_key];
//            if ($this->update($pr, $data)) {
//                return $data[$primary_key];
//            } else {
//                return false;
//            }
//        } else {
//            if ($this->insert($data)) {
//                return $this->_db->lastinsertID();
//            } else {
//                return false;
//            }
//        }
//    }
//
//    public function remove($key) {
//        if ($this->delete($key)) {
//            return true;
//        } else {
//            return false;
//        }
//    }

    public function get_product_info($product_id) {
        if ($r = $this->query("SELECT * FROM $this->selecttable WHERE products_id=?", [$product_id])->one()) {
            $r->primary_key = $this->selecttable . "_id";
            return $r;
        } else {
            return false;
        }
    }

    public function check_product_from_safe_name($product_safe_name) {
        if ($r = $this->query("SELECT product_id FROM $this->selecttable WHERE product_name_sef = ?", [$product_safe_name])->one()) {
            return $r->product_id;
        } else {
            return false;
        }
    }

    public function isThereProduct($product_id) {
        if ($r = $this->query("SELECT product_id FROM $this->selecttable WHERE product_id = ?", [$product_id])->one()) {
            return true;
        } else {
            return false;
        }
    }

    public function get_products_info($start = 0, $end = 10, $direction = "DESC") {
        $limit = " LIMIT " . $start . "," . ($end - $start);
        $r = $this->query("SELECT *,product_id as table_id FROM $this->selecttable ORDER BY $this->selecttable.date $direction $limit", [])->results();
        if (!empty($r)) {
            return $r;
        } else {
            return false;
        }
    }

    public function get_products_total_count() {
        $r = $this->query("SELECT COUNT(*) FROM $this->selecttable ", [])->one();
        return $r->{"COUNT(*)"};
    }

    public function add_new_product($data) {
        if ($this->insert($data)) {
            return $this->_db->lastinsertID();
        } else {
            return false;
        }
    }

}
