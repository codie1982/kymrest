<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class settings_transport_location_fields extends settings_general_rule {

    private $users_id;
    private $province;
    private $district;
    private $neighborhood;
    private $direction;
    private $addmethod;
    private $value;
    private $price_unit;
    private $date;
    private $settings_transport_location_seccode;
    

    public function __construct() {
        $this->table_fields = "settings_transport_location";

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

    public function set_direction($value, $key) {
        $this->direction = $value;
        data::add("direction", $this->direction, $this->table_fields, $key);
    }

    public function set_addmethod($value, $key) {
        $this->addmethod = $value;
        data::add("addmethod", $this->addmethod, $this->table_fields, $key);
    }

    public function set_value($value, $key) {
        $this->value = $value;
        data::add("value", $this->value, $this->table_fields, $key);
    }

    public function set_price_unit($value, $key) {
        $this->price_unit = $value;
        data::add("price_unit", $this->price_unit != "" ? $this->price_unit : default_currency(), $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->date = $value;
        data::add("date", getNow(), $this->table_fields, $key);
    }

    public function set_settings_transport_location_seccode($value, $key) {
        $this->settings_transport_location_seccode = $value;
        data::add("settings_transport_location_seccode", $this->settings_transport_location_seccode == "" ? seccode() : $this->settings_transport_location_seccode, $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = $value;
        data::add("users_id", session::get(CURRENT_USER_SESSION_NAME), $this->table_fields, $key);
    }

}
