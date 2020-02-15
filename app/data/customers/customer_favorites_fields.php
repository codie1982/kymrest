<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class customer_favorites_fields extends customer_rule {

    private $customer_id;
    private $product_id;
    private $public;
    private $admin_public;
    private $customer_favorites_seccode;
    private $date;
    private $users_id;
    private $secret_number;

    public function __construct() {
        $this->table_fields = "customer_favorites";
        return true;
    }

    public function set_secret_number($value) {
        $this->secret_number = $value;
        data::add_secret_number($this->secret_number, $this->table_fields);
    }

    public function set_primary_key($value, $key) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields, $key);
    }

    public function set_customer_id($customer_id, $key) {
        $this->customer_id = $customer_id;
        data::add("customer_id", $this->customer_id !== "" ? input::santize($this->customer_id) : 0, $this->table_fields, $key);
    }

    public function set_product_id($value, $key) {
        $this->product_id = $value;
        data::add("product_id", $this->product_id !== "" ? input::santize($this->product_id) : 0, $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->date = $value;
        data::add("date", $this->date == "" ? getNow() : $this->date, $this->table_fields, $key);
    }

    public function set_customer_favorites_seccode($value, $key) {
        $this->customer_favorites_seccode = seccode();
        data::add("customer_favorites_seccode", $this->customer_favorites_seccode, $this->table_fields, $key);
    }

    public function set_admin_public($value, $key) {
        $this->admin_public = $value;
        data::add("admin_public", $this->admin_public == "" ? 1 : $this->admin_public, $this->table_fields, $key);
    }

    public function set_public($value, $key) {
        $this->public = $value;
        data::add("public", $this->public == "" ? 1 : $this->public, $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = $value;
        data::add("users_id", $this->users_id == "" ? session::get(CURRENT_USER_SESSION_NAME) : $this->users_id, $this->table_fields, $key);
    }

}
