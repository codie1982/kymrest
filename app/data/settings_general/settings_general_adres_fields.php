<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class settings_general_adres_fields extends settings_general_rule {

    public $users_id;

    public function __construct() {
        $this->table_fields = "settings_general_adres";

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

    public function set_province($value, $key) {
        $this->province = $value;
        data::add("province", $this->province, $this->table_fields, $key);
    }

    public function set_district($value, $key) {
        $this->district = $value;
        data::add("district", $this->district, $this->table_fields, $key);
    }

    public function set_neighborhood($value, $key) {
        $this->neighborhood = $value;
        data::add("neighborhood", $this->neighborhood, $this->table_fields, $key);
    }

    public function set_street($value, $key) {
        $this->street = $value;
        data::add("street", $this->street, $this->table_fields, $key);
    }

    public function set_mail_code($value, $key) {
        $this->mail_code = $value;
        data::add("mail_code", $this->mail_code, $this->table_fields, $key);
    }

    public function set_directions($value, $key) {
        $this->directions = $value;
        data::add("directions", $this->directions, $this->table_fields, $key);
    }

    public function set_description($value, $key) {
        $this->description = $value;
        data::add("description", $this->description, $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->date = $value;
        data::add("date", $this->date, $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields, $key);
    }

}
