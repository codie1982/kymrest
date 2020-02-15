<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class product_price_group_fields extends product_rule {

    public $product_id;
    public $group_title;
    public $group_type;
    public $price_type_date;
    public $public;
    public $admin_public;
    public $product_price_group_seccode;
    public $users_id;

    public function __construct() {
        $this->table_fields = "product_price_group";
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

    public function set_parent_key($value, $key) {
        $this->parent_key = $value;
        data::add("parent_key", $this->parent_key !== "" ? $this->parent_key : null, $this->table_fields, $key);
    }

    public function set_group_title($value, $key) {
        $this->group_title = $value;
        data::add("group_title", $this->group_title != "" ? $this->group_title : 0, $this->table_fields, $key);
    }

    public function set_group_type($value, $key) {
        $this->group_type = $value;
        data::add("group_type", $this->group_type != "" ? strtolower(input::santize($this->group_type)) : "checkbox", $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->price_type_date = getNow();
        data::add("date", $this->price_type_date, $this->table_fields, $key);
    }

    public function set_public($value, $key) {
        $this->public = $value;
        data::add("public", $this->public == "" ? 1 : $this->public, $this->table_fields, $key);
    }

    public function set_admin_public($value, $key) {
        $this->admin_public = $value;
        data::add("admin_public", $this->admin_public == "" ? 1 : $this->admin_public, $this->table_fields, $key);
    }

    public function set_product_price_group_seccode($value, $key) {
        $this->product_price_group_seccode = seccode();
        data::add("product_price_group_seccode", $this->product_price_group_seccode, $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields, $key);
    }

}
