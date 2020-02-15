<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class settings_general_currency_fields extends settings_general_currency_fields_rule {

    public $tl;
    public $eu;
    public $dl;

    public function __construct() {
        $this->table_fields = "settings_general_currency";

        return true;
    }

    public function get_table_fields() {
        return $this->table_fields;
    }

    public function set_secret_number($value) {
        $this->secret_number = $value;
        data::add_secret_number($this->secret_number, $this->table_fields);
    }

    public function set_primary_key($value, $key) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields, $key);
    }

    public function set_eu($value, $key) {
        $this->eu = $value;
        data::add("product_currency_price", $this->eu == "" ? 0 : $this->eu, $this->table_fields, $key);
    }

    public function set_dl($value, $key) {
        $this->dl = $value;
        data::add("product_currency_price", $this->dl == "" ? 0 : $this->dl, $this->table_fields, $key);
    }

}
