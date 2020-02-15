<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class job_products_price_options_value_fields extends job_rule {

    private $job_id;
    private $job_products_id;
    private $job_product_price_group_id;
    private $job_product_price_group_title;
    private $job_product_price_group_option_id;
    private $price_title;
    private $direction;
    private $type;
    private $value;
    private $date;
    private $public;
    private $job_products_price_options_value_seccode;
    private $users_id;

    public function __construct() {
        $this->table_fields = "job_products_price_options_value";
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

    public function set_parent_key($value, $key) {
        $this->parent_key = $value;
        data::add("parent_key", $this->parent_key !== "" ? $this->parent_key : null, $this->table_fields, $key);
    }

    public function set_job_id($value, $key) {
        $this->job_id = $value;
        data::add("job_id", $this->job_id !== "" ? $this->job_id : 0, $this->table_fields, $key);
    }

    public function set_job_products_id($value, $key) {
        $this->job_products_id = $value;
        data::add("job_products_id", $this->job_products_id !== "" ? $this->job_products_id : 0, $this->table_fields, $key);
    }

    public function set_job_product_price_group_id($value, $key) {
        $this->job_product_price_group_id = $value;
        data::add("job_product_price_group_id", $this->job_product_price_group_id !== "" ? $this->job_product_price_group_id : 0, $this->table_fields, $key);
    }
    
    public function set_job_product_price_group_option_id($value, $key) {
        $this->job_product_price_group_option_id = $value;
        data::add("job_product_price_group_option_id", $this->job_product_price_group_option_id !== "" ? $this->job_product_price_group_option_id : 0, $this->table_fields, $key);
    }
    
      public function set_job_product_price_group_title($value, $key) {
        $this->job_product_price_group_title = $value;
        data::add("job_product_price_group_title", $this->job_product_price_group_title !== "" ? $this->job_product_price_group_title : NODATA, $this->table_fields, $key);
    }

    public function set_price_title($value, $key) {
        $this->price_title = $value;
        data::add("price_title", $this->price_title !== "" ? $this->price_title : NODATA, $this->table_fields, $key);
    }

    public function set_direction($value, $key) {
        $this->direction = $value;
        data::add("direction", $this->direction !== "" ? $this->direction : "increse", $this->table_fields, $key);
    }

    public function set_type($value, $key) {
        $this->type = $value;
        data::add("type", $this->type !== "" ? $this->type : "rate", $this->table_fields, $key);
    }

    public function set_value($value, $key) {
        $this->value = $value;
        data::add("value", $this->value !== "" ? $this->value : 0, $this->table_fields, $key);
    }

    public function set_public($value, $key) {
        $this->public = $value;
        data::add("public", $this->public !== "" ? $this->public : 1, $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->date = $value;
        data::add("date", $this->date !== "" ? $this->date : getNow(), $this->table_fields, $key);
    }

    public function set_job_products_price_options_value_seccode($value, $key) {
        $this->job_products_price_options_value_seccode = $value;
        data::add("job_products_price_options_value_seccode", $this->job_products_price_options_value_seccode !== "" ? $this->job_products_price_options_value_seccode : seccode(), $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = $value;
        data::add("users_id", $this->users_id !== "" ? $this->users_id : session::get(CURRENT_USER_SESSION_NAME), $this->table_fields, $key);
    }

}
