<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class product_group_fields_value extends product_rule {

    public $product_id;
    public $value_id;
    public $users_id;
    public $fields = [];

    /*
      product_id	int(11)
      value_id	int(11)
      users_id	int(11) */

    public function __construct() {
        $this->table_fields = "product_group_fields_value";
        $nproduct_settings = new table_settings_product();
        $this->product_settings = $nproduct_settings->getProductSettings();
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

    public function get_table_fields() {
        return $this->table_fields;
    }

    public function set_value_id($value, $key) {
        $this->value_id = $value;
        data::add("value_id", $this->value_id, $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields, $key);
    }

}
