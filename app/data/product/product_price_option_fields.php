<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class product_price_option_fields extends product_rule {

    public $product_id;
    public $product_price;
    public $product_price_unit;
    public $product_price_title;
    public $product_price_group_id;
    public $direction;
    public $type;
    public $value;
    public $default_selection;
    public $price_type_date;
    public $options_line;
    public $product_price_option_seccode;
    public $users_id;

    /*
     */

    public function __construct() {
        $this->table_fields = "product_price_option";
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

    public function set_parent_key($value, $key) {
        $this->parent_key = $value;
        data::add("parent_key", $this->parent_key, $this->table_fields, $key);
    }

    public function set_product_price_group_id($value, $key) {
        $this->product_price_group_id = $value;
        data::add("product_price_group_id", $this->product_price_group_id != "" ? strtolower(input::santize($this->product_price_group_id)) : 0, $this->table_fields, $key);
    }

    public function set_product_price_title($value, $key) {
        $this->product_price_title = $value;
        data::add("product_price_title", $this->product_price_title != "" ? strtolower(input::santize($this->product_price_title)) : NODATA, $this->table_fields, $key);
    }

    public function set_direction($value, $key) {
        $this->direction = $value;
        data::add("direction", $this->direction != "" ? strtolower(input::santize($this->direction)) : "increase", $this->table_fields, $key);
    }

    public function set_type($value, $key) {
        $this->type = $value;
        data::add("type", $this->type != "" ? strtolower(input::santize($this->type)) : "rate", $this->table_fields, $key);
    }

    public function set_value($value, $key) {
        $this->value = $value;
        data::add("value", $this->value != "" ? strtolower(input::santize($this->value)) : 0, $this->table_fields, $key);
    }

    public function set_default_selection($value, $key) {
        $this->default_selection = $value;
        data::add("default_selection", $this->default_selection != "" ? strtolower(input::santize($this->default_selection)) : "unselected", $this->table_fields, $key);
    }

    public function set_options_line($value, $key) {
        $this->options_line = $value;
        data::add("options_line", $this->options_line !== "" ? $this->options_line : 0, $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->price_type_date = getNow();
        data::add("date", $this->price_type_date, $this->table_fields, $key);
    }

    public function set_public($value, $key) {
        $this->price_type_date = getNow();
        data::add("date", $this->price_type_date, $this->table_fields, $key);
    }

    public function set_admin_public($value, $key) {
        $this->price_type_date = getNow();
        data::add("date", $this->price_type_date, $this->table_fields, $key);
    }

    public function set_product_price_option_seccode($value, $key) {
        $this->price_type_date = seccode();
        data::add("product_price_option_seccode", $this->price_type_date, $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields, $key);
    }

}
