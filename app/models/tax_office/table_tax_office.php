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
class table_tax_office extends model {

    private $selecttable;

    public function __construct() {
        $this->selecttable = "tax_office";
        parent::__construct($this->selecttable);
    }

    public function getTaxPlacelist($province_id) {
        $sql = "SELECT tax_office_name,tax_office_id FROM $this->selecttable WHERE il_no = ? ";
        return $this->query($sql, [$province_id])->results();
    }

    public function getTaxOfficeName($office_id) {
        $sql = "SELECT tax_office_name FROM $this->selecttable WHERE tax_office_id = ? ";
        if ($r = $this->query($sql, [$office_id])->one()) {
            return $r->tax_office_name;
        } else {
            return false;
        }
    }

}
