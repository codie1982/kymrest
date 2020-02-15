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
class table_specialfields extends model {

    private $selecttable;

    public function __construct($all = true) {
        $this->selecttable = "specialfields";
        parent::__construct($this->selecttable);
    }

    public function getFieldsIdFromSeccode($fields_seccode) {
        if ($r = $this->_db->query("SELECT specialfields_id FROM $this->selecttable WHERE specialfields_seccode = ?", [$fields_seccode])->one()) {
            return $r->specialfields_id;
        } else {
            return true;
        }
    }

    public function removeFields($fields_id) {
        if ($this->_db->query("DELETE FROM $this->selecttable WHERE specialfields_id = ?", [$fields_id])) {
            return true;
        } else {
            return true;
        }
    }

    public function checkProduct($product_name) {
        $r = $this->_db->query("SELECT product_name_sef FROM $this->selecttable WHERE product_name_sef = ?", [sef_link($product_name)])->one();
        if ($r->product_name_sef == sef_link($product_name)) {
            return false;
        } else {
            return true;
        }
    }

    public function checkSpecialFieldsSeccode($special_fields_seccode) {
        if ($r = $this->_db->query("SELECT specialfields_id FROM $this->selecttable WHERE specialfields_seccode = ?", [$special_fields_seccode])->one()) {
            return $r->specialfields_id;
        } else {
            return false;
        }
    }

    public function checkSpecialFields($special_fields_name) {
        if ($this->_db->query("SELECT specialfields_id FROM $this->selecttable WHERE fields_name_sef = ?", [sef_link($special_fields_name)])->one()) {
            return false;
        } else {
            return true;
        }
    }

    public function addSpecialFields($fields_name, $fields_type) {
        if ($_POST) {
            $fields = [
                "fields_name" => strtolower(input::santize($fields_name)),
                "fields_name_sef" => sef_link(input::santize($fields_name)),
                "fields_type" => input::santize($fields_type),
                "date" => getNow(),
                "public" => 1,
                "specialfields_seccode" => seccode(),
                "users_id" => session::get(CURRENT_USER_SESSION_NAME),
            ];

            if ($this->insert($fields)) {

                return $this->_db->lastinsertID();
            } else {
                return false;
            }
        }
    }

    public function updateSpecialFields($fields_name, $fields_type, $fields_id) {
        if ($_POST) {
            $fields = [
                "fields_name" => strtolower(input::santize($fields_name)),
                "fields_name_sef" => sef_link(input::santize($fields_name)),
                "fields_type" => input::santize($fields_type),
                "public" => 1,
            ];

            if ($this->update($fields_id, $fields, "specialfields_id")) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function get_special_fiels() {
        if ($r = $this->query("SELECT * FROM $this->selecttable ", [])->results()) {
            return $r;
        } else {
            return false;
        }
    }

    public function getSpecialFieldInfo($field_id, $filter = " * ") {
        if ($r = $this->query("SELECT $filter FROM $this->selecttable  WHERE specialfields_id = ?", [$field_id])->one()) {
            return $r;
        } else {
            return false;
        }
    }

    public function searchAllSpecialFileds($search_item) {
        $qsef = "%{$search_item}%";
        if ($results = $this->query("SELECT product_special_fields_value.value_id FROM product 
            INNER JOIN product_special_fields_value ON product_special_fields_value.product_id=product.product_id
            WHERE product_name LIKE ?  ", [$qsef])->results()) {
            return $results;
        } else {
            return false;
        }
    }

}
