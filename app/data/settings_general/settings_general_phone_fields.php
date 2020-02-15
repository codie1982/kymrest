<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class settings_general_phone_fields extends settings_general_rule {

    public $users_id;

    public function __construct() {
        $this->table_fields = "settings_general_phone";
        $nproduct_settings = new table_settings_product();
        $this->product_settings = $nproduct_settings->getProductSettings();
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

    public function set_phone_type($value, $key) {
        $this->phone_type = $value;
        data::add("phone_type", $this->phone_type, $this->table_fields, $key);
    }

    public function set_area_code($value, $key) {
        $this->area_code = $value;
        data::add("area_code", $this->area_code, $this->table_fields, $key);
    }

    public function set_phone_number($value, $key) {
        $this->phone_number = $value;
        data::add("phone_number", $this->phone_number, $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->date = $value;
        data::add("date", $this->date, $this->table_fields, $key);
    }

    public function set_public($value, $key) {
        $this->public = $value;
        data::add("public", $this->public, $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields, $key);
    }

}
