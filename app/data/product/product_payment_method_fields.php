<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class product_payment_method_fields extends product_rule {

    public $product_id;
    public $payment_method;
    public $payment_method_extra_price;
    public $extra_price_unit;
    public $payment_method_date;
    public $product_payment_method_seccode;
    public $users_id;
    public $fields = [];

    /*
      product_id                      int(11)
      payment_method                  varchar(45)
      payment_method_extra_price	double
      extra_price_unit                varchar(11)
      date                            timestamp
      product_payment_method_seccode	varchar(45)
      users_id                        int(11)
     */

    public function __construct() {
        $this->table_fields = "product_payment_method";
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

    public function set_payment_method($value, $key) {
        $this->payment_method = $value;
        data::add("payment_method", $this->payment_method, $this->table_fields, $key);
    }

    public function set_payment_method_extra_price($value, $key) {
        $this->payment_method_extra_price = $value;
        data::add("payment_method_extra_price", $this->payment_method_extra_price, $this->table_fields, $key);
    }

    public function set_extra_price_unit($value, $key) {
        $this->extra_price_unit = $value;
        data::add("extra_price_unit", $this->extra_price_unit, $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->payment_method_date = getNow();
        data::add("date", $this->payment_method_date, $this->table_fields, $key);
    }

    public function set_product_payment_method_seccode($value, $key) {
        $this->product_payment_method_seccode = seccode();
        data::add("product_payment_method_seccode", $this->product_payment_method_seccode, $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields, $key);
    }

}
