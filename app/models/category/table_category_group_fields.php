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
class table_category_group_fields extends general {

    public function __construct($all = true) {
        $this->selecttable = "category_group_fields";
        parent::__construct($this->selecttable);
        $this->group_fields_value_columbs = $this->get_columns();
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
//    public function get_data_main_key($category_id) {
//        $prm = $this->selecttable . "_id";
//        if ($res = $this->query("SELECT * FROM $this->selecttable WHERE category_id=?", [$category_id])->results()) {
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
}
