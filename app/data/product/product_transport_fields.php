<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class product_transport_fields extends product_rule {

    public $product_settings;
    public $product_transport_type;
    public $product_transport_price;
    public $product_transport_price_unit;
    public $product_intransport;
    public $date;
    public $public;
    public $transport_location;
    public $seccode;
    public $users_id;

    public function __construct() {
        $this->table_fields = "product_transport";
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

    public function set_product_transport_type($value, $key) {
        $this->product_transport_type = $value;
        data::add("product_transport_type", $this->product_transport_type, $this->table_fields, $key);
    }

    public function set_product_transport_price($value, $key) {
        $this->product_transport_price = $value;
        data::add("product_transport_price", isset($value) && $this->product_transport_price !== "" ? $this->product_transport_price : 0, $this->table_fields, $key);
    }

    public function set_product_transport_price_unit($value, $key) {
        $this->product_transport_price_unit = $value;
        data::add("product_transport_price_unit", isset($value) && $this->product_transport_price_unit !== NODATA ? $this->product_transport_price_unit : $this->product_settings->product_default_currency, $this->table_fields, $key);
    }

//product_intransport
    public function set_product_intransport($value, $key) {
        $this->product_intransport = $value;
        data::add("product_intransport", $value == "" ? 0 : 1, $this->table_fields, $key);
    }

    public function set_transport_location($value, $key) {
        $this->transport_location = $value;
        data::add("transport_location", $value == "" ? "all" : $this->transport_location, $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->date = getNow();
        data::add("date", $this->date, $this->table_fields, $key);
    }

    public function set_public($value, $key) {
        $this->public = $value;
        data::add("public", $this->public == "" ? 1 : $this->public, $this->table_fields, $key);
    }

    public function set_seccode($value, $key) {
        $this->seccode = seccode();
        data::add("seccode", $this->seccode, $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields, $key);
    }

}
