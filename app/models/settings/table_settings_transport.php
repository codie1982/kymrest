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
class table_settings_transport extends general {

    public function __construct($table = "") {
        $this->selecttable = "settings_transport";
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
//    public function insert_data($data) {
//        $primary_key = $this->selecttable . "_id";
//        if (isset($data[$primary_key])) {
//            $pr = $data[$primary_key];
//            unset($data[$primary_key]);
//            $this->showsql(true);
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
//        if ($r = $this->delete($key)) {
//            return true;
//        } else {
//            return false;
//        }
//    }



    public function get_settings_transport() {
        if ($r = $this->query("SELECT * FROM $this->selecttable", [])->results()) {
            foreach ($res as $r) {
                $r->primary_key = $this->selecttable . "_id";
            }
            return $res;
        } else {
            return false;
        }
    }

    public function get_transport_settings($filter = " * ") {
        $sql = "SELECT $filter FROM $this->selecttable";
        $r = $this->query($sql)->one();
        if ($r) {
            return $r;
        } else {
            return false;
        }
    }

}
