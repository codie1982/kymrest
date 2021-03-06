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
class table_product_group_fields_value extends general {


    public function __construct($all = false) {
        $this->selecttable = "product_group_fields_value";
        parent::__construct($this->selecttable);
    }

    public function get_table_name() {
        return $this->selecttable;
    }

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
//
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

    public function getProductSpecialFieldsValueList($product_id) {
        if ($r = $this->query("SELECT value_id FROM $this->selecttable  WHERE product_id = ?", [$product_id])->results()) {
            $_r = [];
            foreach ($r as $rr) {
                $_r[] = get_object_vars($rr);
            }
            return $_r;
        } else {
            return false;
        }
    }

    public function addNewProductSpecielFielsValue($special_fields, $product_id) {
        if (!empty($special_fields)) {
            foreach ($special_fields as $value) {

                $productspecialfieldsvalue = new productspecialfieldsvalue();
                $productspecialfieldsvalue->set_product_id($product_id);
                $productspecialfieldsvalue->set_value_id($value);
                $productspecialfieldsvalue->set_users_id();
                $pspecial_fields = $productspecialfieldsvalue->getFields();

                $this->insert($pspecial_fields);
            }
            return true;
        } else {
            return false;
        }
    }

    public function updateProductSpecielFielsValue($special_fields, $product_id) {
        $this->delete($product_id, "product_id");
        if (!empty($special_fields)) {
            foreach ($special_fields as $value) {

                $productspecialfieldsvalue = new productspecialfieldsvalue();
                $productspecialfieldsvalue->set_product_id($product_id);
                $productspecialfieldsvalue->set_value_id($value);
                $productspecialfieldsvalue->set_users_id();
                $pspecial_fields = $productspecialfieldsvalue->getFields();

                $this->insert($pspecial_fields);
            }
            return true;
        } else {
            return false;
        }
    }

}
