<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of settings
 *
 * @author engin
 */
class table_settings_product extends general {

    public function __construct($table = "") {
        $this->selecttable = "settings_product";
        parent::__construct($this->selecttable);
        return true;
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
//
//    public function insert_data($data) {
//        //$this->showsql(true);
//
//        $primary_key = $this->selecttable . "_id";
//        if (isset($data[$primary_key])) {
//            $pr = $data[$primary_key];
//
//            if ($this->update($pr, $data)) {
//                return $data[$primary_key];
//            } else {
//                return false;
//            }
//        } else {
////            dnd($data);
////            $this->showsql(true);
//            if ($this->insert($data)) {
//                return $this->_db->lastinsertID();
//            } else {
//                return false;
//            }
//        }
//    }
//
//     public function remove($key) {
//        if ($r = $this->delete($key)) {
//            return true;
//        } else {
//            return false;
//        }
//    }
    public function new_product_settings($data) {
        if ($r = $this->query("SELECT settings_product_id FROM $this->selecttable", [])->one()) {
            if ($this->update(0, $data)) {
                $this->update(0, ["prepare" => 1]);
                return true;
            } else {
                return false;
            }
        } else {
            if ($this->insert($data)) {
                $this->update(0, ["prepare" => 1]);
                return true;
            } else {
                return false;
            }
        }
    }

    public function get_settings_product() {
        if ($r = $this->query("SELECT * FROM $this->selecttable", [])->results()) {
            foreach ($res as $r) {
                $r->primary_key = $this->selecttable . "_id";
            }
            return $res;
        } else {
            return false;
        }
    }

    public function getProductSettings($filter = " * ") {
        $sql = "SELECT $filter FROM $this->selecttable";
        $r = $this->query($sql)->one();
        if ($r) {
            return $r;
        } else {
            return false;
        }
    }

    public function getProductCurrency($filter = " * ") {
        $sql = "SELECT $filter FROM product_currency ORDER BY product_currency_id ASC";
        $r = $this->query($sql)->results();
        if ($r) {
            return $r;
        } else {
            return false;
        }
    }

    public function removeCurrency($currency_seccode) {
        if ($this->_db->delete("product_currency", $currency_seccode, "product_currency_seccode")) {
            return true;
        } else {
            return false;
        }
    }

    public function getProductThreshold($price, $treshold_rate, $treshold_type = "rate") {
        $temp = $price;
        if ($treshold_type == "rate") {
            if ($treshold_rate != 0) {
                $temp = $temp - (($temp * $treshold_rate) / 100);
            } else {
                $temp = $price;
            }

            if ($temp < 0) {
                $temp = 0;
            }
        } else {
            if ($treshold_rate != $temp) {
                $temp = $temp - $treshold_rate;
            } else {
                $temp = 0;
            }
        }

        return $temp;
    }

}
