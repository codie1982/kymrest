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
class table_settings_general extends general {


    public function __construct($table = "") {
        $this->selecttable = "settings_general";
        parent::__construct($this->selecttable);
        return true;
    }

    public function get_table_name() {
        return $this->selecttable;
    }

//
//   public function get_data($primary_id = null) {
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
//    public function remove($key) {
//        if ($r = $this->delete($key)) {
//            return true;
//        } else {
//            return false;
//        }
//    }
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

    public function new_general_settings($data) {
        if ($r = $this->query("SELECT settings_general_id FROM $this->selecttable", [])->one()) {
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

    public function get_general_settings() {
        if ($r = $this->query("SELECT * FROM $this->selecttable", [])->one()) {
            $r->primary_key = $this->selecttable . "_id";
            return $r;
        } else {
            return false;
        }
    }

}
