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
class table_settings_grnt extends general {

    public $selecttable;

    public function __construct($table = "") {
        $this->selecttable = "settings_grnt";
        parent::__construct($this->selecttable);
        return true;
    }

    public function get_table_name() {
        return $this->selecttable;
    }

    public function get_data($primary_id = 0) {
        $prm = $this->selecttable . "_id";
        if ($r = $this->query("SELECT * FROM $this->selecttable WHERE $prm = ?", [$primary_id])->one()) {
            $r->primary_key = $prm;
            return $r;
        } else {
            return false;
        }
    }



    public function new_tema_settings($data) {
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

    public function get_tema_settings() {
        $prm = $this->selecttable . "_id";
        if ($r = $this->query("SELECT * FROM $this->selecttable ORDER BY $prm DESC LIMIT 1", [])->one()) {
            $r->primary_key = $this->selecttable . "_id";
            return $r;
        } else {
            return false;
        }
    }

}
