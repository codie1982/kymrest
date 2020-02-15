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
class table_group_fields_value extends general {

    public function __construct($all = true) {
        $this->selecttable = "group_fields_value";
        parent::__construct($this->selecttable);
        $this->group_fields_value_columbs = $this->get_columns();
    }

    public function get_table_name() {
        return $this->selecttable;
    }

}
