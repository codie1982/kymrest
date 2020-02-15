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
class specialfields_value extends model {

    private $_selecttable;
    private $_category_list;

    public function __construct($all = true) {
        $this->_selecttable = "specialfields_value";
        parent::__construct($this->_selecttable);
    }

    public function getfiledsValuelist($fields_id) {
        if ($r = $this->_db->query("SELECT * FROM $this->_selecttable WHERE specialfields_id = ? ", [$fields_id])->results()) {
            return $r;
        } else {
            return false;
        }
    }

    public function getSpecialFieldsValueInfo($specialfields_value_id) {
        if ($r = $this->_db->query("SELECT * FROM $this->_selecttable WHERE specialfields_value_id = ? ", [$specialfields_value_id])->one()) {
            return $r;
        } else {
            return false;
        }
    }

    public function getValueIdFromSeccode($field_seccode) {
        if ($r = $this->_db->query("SELECT specialfields_value_id FROM $this->_selecttable WHERE specialfields_value_seccode = ? ", [$field_seccode])->one()) {
            return $r->specialfields_value_id;
        } else {
            return false;
        }
    }

    public function removeFieldsValue($filedsValueid) {
        if ($this->_db->query("DELETE FROM $this->_selecttable WHERE specialfields_value_id = ? ", [$filedsValueid])) {
            return true;
        } else {
            return false;
        }
    }

    public function checkSpecialFields_value($specialfields_value_name, $fields_id) {
        return !$this->_db->query("SELECT fields_name_sef FROM $this->_selecttable WHERE specialfields_value_name = ? && specialfields_id = ?", [$specialfields_value_name, $fields_id])->one();
    }

    public function addSpecialFields_value($fields_values = [], $fields_id) {
        if ($_POST) {
            $i = 0;
            foreach ($fields_values as $vl) {
                $i++;
                $fields = [
                    "specialfields_id" => $fields_id,
                    "specialfields_value_name" => input::santize($vl),
                    "specialfields_value_name_sef" => sef_link(input::santize($vl)),
                    "line" => $i,
                    "date" => getNow(),
                    "public" => 1,
                    "specialfields_value_seccode" => seccode(),
                    "users_id" => session::get(CURRENT_USER_SESSION_NAME),
                ];
                $this->insert($fields);
            }

            return true;
        }
    }

    public function addSpecialField_value($fields_value, $fields_id, $i) {
        if ($_POST) {
            $fields = [
                "specialfields_id" => $fields_id,
                "specialfields_value_name" => input::santize($fields_value),
                "specialfields_value_name_sef" => sef_link(input::santize($fields_value)),
                "line" => $i,
                "date" => getNow(),
                "public" => 1,
                "specialfields_value_seccode" => seccode(),
                "users_id" => session::get(CURRENT_USER_SESSION_NAME),
            ];
            $this->insert($fields);
            return true;
        }
    }

    public function updateSpecialField_value($fields_value, $fields_id, $value_id) {
        if ($_POST) {
            $fields = [
                "specialfields_id" => $fields_id,
                "specialfields_value_name" => input::santize($fields_value),
                "specialfields_value_name_sef" => sef_link(input::santize($fields_value)),
                "public" => 1,
            ];
            if ($this->update($value_id, $fields, "specialfields_value_id")) {
                return true;
            } else {
                return false;
            }
        }
    }

}
